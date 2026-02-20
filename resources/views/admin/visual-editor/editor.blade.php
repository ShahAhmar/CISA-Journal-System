<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Visual Editor - {{ $page->page_title }}</title>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body, html { height: 100%; margin: 0; overflow: hidden; background-color: #444; }
        
        /* Main Layout */
        .editor-row { display: flex; justify-content: flex-start; align-items: stretch; flex-wrap: nowrap; height: calc(100% - 40px); }
        .editor-canvas { flex-grow: 1; height: 100%; }
        
        /* Sidebar Panels */
        .panel__right { width: 300px; height: 100%; background-color: #2d2d2d; color: white; display: flex; flex-direction: column; border-left: 1px solid #111; }
        .panel__top { height: 40px; background-color: #2d2d2d; border-bottom: 1px solid #111; display: flex; align-items: center; justify-content: space-between; padding: 0 15px; color: #ddd; }
        
        /* GrapesJS Overrides */
        .gjs-cv-canvas { width: 100%; height: 100%; top: 0; }
        .gjs-blocks-c { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 15px; }
        .gjs-block { width: auto; height: auto; min-height: 80px; background-color: #3d3d3d; color: white; border: 1px solid #444; padding: 10px; border-radius: 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 11px; cursor: pointer; transition: 0.2s; }
        .gjs-block:hover { background-color: #ecae21; color: #111; }
        .gjs-block i { font-size: 20px; margin-bottom: 5px; }
        
        .gjs-pn-btn { color: #ccc; }
        .gjs-pn-btn.gjs-pn-active { color: #ecae21; background-color: transparent !important; box-shadow: none !important; }
        
        #blocks-container { flex-grow: 1; overflow-y: auto; }
        #styles-container { flex-grow: 1; overflow-y: auto; display: none; }
        
        .sidebar-header { padding: 12px 15px; background: #222; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #999; border-bottom: 1px solid #111; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
        .sidebar-header.active { background: #333; color: #ecae21; }
        
        /* Save Button Pulse */
        .btn-save-db { background-color: #ecae21 !important; color: #111 !important; font-weight: 800 !important; cursor: pointer; border-radius: 4px; padding: 5px 15px !important; margin-left: 10px; }
    </style>
</head>
<body>

    <div class="panel__top">
        <div class="flex items-center">
            <i class="fas fa-magic text-yellow-500 mr-2"></i>
            <span class="font-bold text-sm">Visual Editor: {{ $page->page_title }}</span>
        </div>
        <div class="panel__devices"></div>
        <div class="panel__basic-actions"></div>
    </div>

    <div class="editor-row">
        <div class="editor-canvas">
            <div id="gjs">
                @if($page->content_html)
                    {!! $page->content_html !!}
                @else
                    <section class="py-24 bg-white text-center">
                        <div class="max-w-4xl mx-auto px-6">
                            <h1 class="text-5xl font-serif font-bold text-slate-900 mb-6 font-playfair">Start Building Your Page</h1>
                            <p class="text-xl text-slate-600 mb-10">Drag blocks from the right sidebar to design your page visually.</p>
                            <div class="inline-block px-8 py-3 bg-amber-500 text-white font-bold rounded-lg shadow-lg">Welcome to GrapesJS</div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
        
        <div class="panel__right">
            <div class="sidebar-header active" id="tab-blocks">
                <span>Layout Blocks</span>
                <i class="fas fa-th-large"></i>
            </div>
            <div id="blocks-container"></div>
            
            <div class="sidebar-header" id="tab-styles">
                <span>Styles & Config</span>
                <i class="fas fa-paint-brush"></i>
            </div>
            <div id="styles-container" style="padding: 10px;"></div>

            <div class="p-4 bg-slate-800 border-t border-slate-700 mt-auto">
                <a href="{{ route('admin.journal-pages.index', ['journal' => $page->journal_id]) }}" class="text-xs text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const editor = grapesjs.init({
            container: '#gjs',
            fromElement: true,
            height: '100%',
            width: 'auto',
            storageManager: false,
            blockManager: {
                appendTo: '#blocks-container',
            },
            styleManager: {
                appendTo: '#styles-container',
            },
            deviceManager: {
                devices: [
                    { name: 'Desktop', width: '' },
                    { name: 'Mobile', width: '320px', widthMedia: '480px' },
                ]
            },
            panels: {
                defaults: [
                    {
                        id: 'options',
                        el: '.panel__basic-actions',
                        buttons: [
                            {
                                id: 'visibility',
                                active: true,
                                className: 'btn-toggle-borders',
                                label: '<i class="fa fa-clone"></i>',
                                command: 'sw-visibility',
                            },
                            {
                                id: 'export',
                                className: 'btn-open-export',
                                label: '<i class="fa fa-code"></i>',
                                command: 'export-template',
                            },
                            {
                                id: 'save-db',
                                className: 'btn-save-db',
                                label: 'SAVE CHANGES',
                                command: 'save-db',
                            }
                        ],
                    },
                    {
                        id: 'devices-c',
                        el: '.panel__devices',
                        buttons: [
                            {
                                id: 'device-desktop',
                                label: '<i class="fa fa-desktop"></i>',
                                command: 'set-device-desktop',
                                active: true,
                                togglable: false,
                            },
                            {
                                id: 'device-mobile',
                                label: '<i class="fa fa-mobile-alt"></i>',
                                command: 'set-device-mobile',
                                togglable: false,
                            }
                        ]
                    }
                ]
            },
            canvas: {
                styles: [
                    'https://cdn.tailwindcss.com',
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
                    'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap'
                ],
                scripts: [
                   'https://cdn.tailwindcss.com'
                ]
            }
        });

        // Tab Handling
        document.getElementById('tab-blocks').onclick = () => {
            document.getElementById('blocks-container').style.display = 'block';
            document.getElementById('styles-container').style.display = 'none';
            document.getElementById('tab-blocks').classList.add('active');
            document.getElementById('tab-styles').classList.remove('active');
        };
        document.getElementById('tab-styles').onclick = () => {
            document.getElementById('blocks-container').style.display = 'none';
            document.getElementById('styles-container').style.display = 'block';
            document.getElementById('tab-blocks').classList.remove('active');
            document.getElementById('tab-styles').classList.add('active');
        };

        // Commands
        editor.Commands.add('set-device-desktop', { run: ed => ed.setDevice('Desktop') });
        editor.Commands.add('set-device-mobile', { run: ed => ed.setDevice('Mobile') });

        // Save
        editor.Commands.add('save-db', {
            run: function(editor, sender) {
                sender && sender.set('active', 0);
                const htmldata = editor.getHtml();
                const cssdata = editor.getCss();
                const components = JSON.stringify(editor.getComponents());

                fetch('{{ route('admin.visual-editor.store', $page->id) }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ html: htmldata, css: cssdata, components: components })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) alert('Success: Design saved!');
                    else alert('Error: Save failed.');
                });
            }
        });

        // Add Premium Blocks
        const bm = editor.BlockManager;

        bm.add('hero-box', {
            label: '<i class="fas fa-bolt"></i><div>Modern Hero</div>',
            content: `
                <section class="py-24 bg-slate-900 text-white text-center">
                    <div class="max-w-4xl mx-auto px-6">
                        <h1 class="text-6xl font-serif font-bold mb-6 tracking-tight">Excellence in Research</h1>
                        <p class="text-xl text-slate-300 mb-10 leading-relaxed">Join a community of dedicated scholars and advance global knowledge.</p>
                        <div class="flex justify-center gap-4">
                            <a href="#" class="px-8 py-4 bg-amber-500 text-white font-bold rounded-lg hover:bg-amber-600 transition-all">Submit Paper</a>
                            <a href="#" class="px-8 py-4 bg-white/10 text-white font-bold rounded-lg hover:bg-white/20 transition-all backdrop-blur-md">Learn More</a>
                        </div>
                    </div>
                </section>`
        });

        bm.add('text-dual', {
            label: '<i class="fas fa-columns"></i><div>2 Columns</div>',
            content: `
                <div class="py-16 bg-white">
                    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Our Vision</h2>
                            <p class="text-slate-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
                            <p class="text-slate-600">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>`
        });

        bm.add('cta-simple', {
            label: '<i class="fas fa-bullhorn"></i><div>CTA Banner</div>',
            content: `
                <div class="py-12 bg-amber-500 text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Call for Papers - Winter 2025</h2>
                    <a href="#" class="inline-block px-10 py-4 bg-slate-900 text-white font-bold rounded-full">Register Today</a>
                </div>`
        });

    </script>
</body>
</html>