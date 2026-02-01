<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Submission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OAIPMHController extends Controller
{
    public function index(Request $request)
    {
        $verb = $request->get('verb');
        $identifier = $request->get('identifier');
        $metadataPrefix = $request->get('metadataPrefix', 'oai_dc');
        $from = $request->get('from');
        $until = $request->get('until');
        $set = $request->get('set'); // Journal identifier
        $resumptionToken = $request->get('resumptionToken');

        // Basic OAI-PMH response structure
        $response = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $response .= '<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/ http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">' . "\n";
        $response .= '  <responseDate>' . now()->toIso8601String() . '</responseDate>' . "\n";
        $response .= '  <request';
        foreach ($request->all() as $key => $value) {
            $response .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
        }
        $response .= '>' . route('oai-pmh.index') . '</request>' . "\n";

        if (!$verb) {
            $response .= $this->error('badVerb', 'Missing verb parameter');
        } else {
            switch ($verb) {
                case 'Identify':
                    $response .= $this->identify();
                    break;
                case 'ListMetadataFormats':
                    $response .= $this->listMetadataFormats($identifier);
                    break;
                case 'ListSets':
                    $response .= $this->listSets();
                    break;
                case 'ListIdentifiers':
                    $response .= $this->listIdentifiers($metadataPrefix, $from, $until, $set, $resumptionToken);
                    break;
                case 'ListRecords':
                    $response .= $this->listRecords($metadataPrefix, $from, $until, $set, $resumptionToken);
                    break;
                case 'GetRecord':
                    $response .= $this->getRecord($identifier, $metadataPrefix);
                    break;
                default:
                    $response .= $this->error('badVerb', 'Illegal verb: ' . $verb);
            }
        }

        $response .= '</OAI-PMH>';

        return response($response)->header('Content-Type', 'text/xml');
    }

    private function identify()
    {
        $xml = '  <Identify>' . "\n";
        $xml .= '    <repositoryName>' . htmlspecialchars(config('app.name')) . '</repositoryName>' . "\n";
        $xml .= '    <baseURL>' . route('oai-pmh.index') . '</baseURL>' . "\n";
        $xml .= '    <protocolVersion>2.0</protocolVersion>' . "\n";
        $xml .= '    <adminEmail>' . config('mail.from.address') . '</adminEmail>' . "\n";
        $xml .= '    <earliestDatestamp>' . Carbon::parse('2020-01-01')->toIso8601String() . '</earliestDatestamp>' . "\n";
        $xml .= '    <deletedRecord>no</deletedRecord>' . "\n";
        $xml .= '    <granularity>YYYY-MM-DDThh:mm:ssZ</granularity>' . "\n";
        $xml .= '  </Identify>' . "\n";
        return $xml;
    }

    private function listMetadataFormats($identifier = null)
    {
        $xml = '  <ListMetadataFormats>' . "\n";
        $xml .= '    <metadataFormat>' . "\n";
        $xml .= '      <metadataPrefix>oai_dc</metadataPrefix>' . "\n";
        $xml .= '      <schema>http://www.openarchives.org/OAI/2.0/oai_dc.xsd</schema>' . "\n";
        $xml .= '      <metadataNamespace>http://www.openarchives.org/OAI/2.0/oai_dc/</metadataNamespace>' . "\n";
        $xml .= '    </metadataFormat>' . "\n";
        $xml .= '  </ListMetadataFormats>' . "\n";
        return $xml;
    }

    private function listSets()
    {
        $xml = '  <ListSets>' . "\n";
        $journals = Journal::where('is_active', true)->get();
        foreach ($journals as $journal) {
            $xml .= '    <set>' . "\n";
            $xml .= '      <setSpec>' . htmlspecialchars($journal->slug) . '</setSpec>' . "\n";
            $xml .= '      <setName>' . htmlspecialchars($journal->name) . '</setName>' . "\n";
            $xml .= '    </set>' . "\n";
        }
        $xml .= '  </ListSets>' . "\n";
        return $xml;
    }

    private function listIdentifiers($metadataPrefix, $from, $until, $set, $resumptionToken)
    {
        if ($metadataPrefix !== 'oai_dc') {
            return $this->error('cannotDisseminateFormat', 'Metadata format not supported');
        }

        $query = Submission::where('status', 'published')
            ->whereHas('journal', function($q) {
                $q->where('is_active', true);
            });

        if ($set) {
            $query->whereHas('journal', function($q) use ($set) {
                $q->where('slug', $set);
            });
        }

        if ($from) {
            $query->whereDate('published_at', '>=', $from);
        }

        if ($until) {
            $query->whereDate('published_at', '<=', $until);
        }

        $submissions = $query->orderBy('published_at', 'desc')->limit(100)->get();

        $xml = '  <ListIdentifiers>' . "\n";
        foreach ($submissions as $submission) {
            $xml .= '    <header>' . "\n";
            $xml .= '      <identifier>oai:' . config('app.name') . ':' . $submission->id . '</identifier>' . "\n";
            $xml .= '      <datestamp>' . $submission->updated_at->toIso8601String() . '</datestamp>' . "\n";
            $xml .= '      <setSpec>' . htmlspecialchars($submission->journal->slug) . '</setSpec>' . "\n";
            $xml .= '    </header>' . "\n";
        }
        $xml .= '  </ListIdentifiers>' . "\n";
        return $xml;
    }

    private function listRecords($metadataPrefix, $from, $until, $set, $resumptionToken)
    {
        if ($metadataPrefix !== 'oai_dc') {
            return $this->error('cannotDisseminateFormat', 'Metadata format not supported');
        }

        $query = Submission::where('status', 'published')
            ->whereHas('journal', function($q) {
                $q->where('is_active', true);
            });

        if ($set) {
            $query->whereHas('journal', function($q) use ($set) {
                $q->where('slug', $set);
            });
        }

        if ($from) {
            $query->whereDate('published_at', '>=', $from);
        }

        if ($until) {
            $query->whereDate('published_at', '<=', $until);
        }

        $submissions = $query->orderBy('published_at', 'desc')->limit(100)->get();

        $xml = '  <ListRecords>' . "\n";
        foreach ($submissions as $submission) {
            $xml .= '    <record>' . "\n";
            $xml .= '      <header>' . "\n";
            $xml .= '        <identifier>oai:' . config('app.name') . ':' . $submission->id . '</identifier>' . "\n";
            $xml .= '        <datestamp>' . $submission->updated_at->toIso8601String() . '</datestamp>' . "\n";
            $xml .= '        <setSpec>' . htmlspecialchars($submission->journal->slug) . '</setSpec>' . "\n";
            $xml .= '      </header>' . "\n";
            $xml .= '      <metadata>' . "\n";
            $xml .= $this->getDublinCoreMetadata($submission);
            $xml .= '      </metadata>' . "\n";
            $xml .= '    </record>' . "\n";
        }
        $xml .= '  </ListRecords>' . "\n";
        return $xml;
    }

    private function getRecord($identifier, $metadataPrefix)
    {
        if ($metadataPrefix !== 'oai_dc') {
            return $this->error('cannotDisseminateFormat', 'Metadata format not supported');
        }

        // Extract ID from identifier (format: oai:app:123)
        $parts = explode(':', $identifier);
        $id = end($parts);

        $submission = Submission::where('id', $id)
            ->where('status', 'published')
            ->first();

        if (!$submission) {
            return $this->error('idDoesNotExist', 'The value of the identifier argument is unknown or illegal');
        }

        $xml = '  <GetRecord>' . "\n";
        $xml .= '    <record>' . "\n";
        $xml .= '      <header>' . "\n";
        $xml .= '        <identifier>' . htmlspecialchars($identifier) . '</identifier>' . "\n";
        $xml .= '        <datestamp>' . $submission->updated_at->toIso8601String() . '</datestamp>' . "\n";
        $xml .= '        <setSpec>' . htmlspecialchars($submission->journal->slug) . '</setSpec>' . "\n";
        $xml .= '      </header>' . "\n";
        $xml .= '      <metadata>' . "\n";
        $xml .= $this->getDublinCoreMetadata($submission);
        $xml .= '      </metadata>' . "\n";
        $xml .= '    </record>' . "\n";
        $xml .= '  </GetRecord>' . "\n";
        return $xml;
    }

    private function getDublinCoreMetadata(Submission $submission)
    {
        $xml = '        <oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">' . "\n";
        
        // Title
        $xml .= '          <dc:title>' . htmlspecialchars($submission->title) . '</dc:title>' . "\n";
        
        // Authors
        foreach ($submission->authors as $author) {
            $xml .= '          <dc:creator>' . htmlspecialchars($author->full_name) . '</dc:creator>' . "\n";
        }
        
        // Abstract
        if ($submission->abstract) {
            $xml .= '          <dc:description>' . htmlspecialchars($submission->abstract) . '</dc:description>' . "\n";
        }
        
        // Keywords
        if ($submission->keywords) {
            $keywords = is_array($submission->keywords) ? $submission->keywords : explode(',', $submission->keywords);
            foreach ($keywords as $keyword) {
                $xml .= '          <dc:subject>' . htmlspecialchars(trim($keyword)) . '</dc:subject>' . "\n";
            }
        }
        
        // Journal
        if ($submission->journal) {
            $xml .= '          <dc:publisher>' . htmlspecialchars($submission->journal->name) . '</dc:publisher>' . "\n";
        }
        
        // Date
        if ($submission->published_at) {
            $xml .= '          <dc:date>' . $submission->formatPublishedAt('Y-m-d') . '</dc:date>' . "\n";
        }
        
        // Type
        $xml .= '          <dc:type>article</dc:type>' . "\n";
        
        // Language
        $xml .= '          <dc:language>en</dc:language>' . "\n";
        
        // Identifier (DOI)
        if ($submission->doi) {
            $xml .= '          <dc:identifier>' . htmlspecialchars($submission->doi) . '</dc:identifier>' . "\n";
        }
        
        // URL
        if ($submission->journal) {
            $xml .= '          <dc:identifier>' . route('journals.article', [$submission->journal->slug, $submission->id]) . '</dc:identifier>' . "\n";
        }
        
        $xml .= '        </oai_dc:dc>' . "\n";
        return $xml;
    }

    private function error($code, $message)
    {
        $xml = '  <error code="' . htmlspecialchars($code) . '">' . htmlspecialchars($message) . '</error>' . "\n";
        return $xml;
    }
}

