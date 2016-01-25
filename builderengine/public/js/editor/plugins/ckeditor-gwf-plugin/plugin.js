CKEDITOR.plugins.add('ckeditor-gwf-plugin',
    {
        popup: null,
        fontLabel: null,
        init: function (editor) {
            editor.config.gwfplugin = editor.config.gwfplugin || {
                font: {},
                cancel: {},
                ok: {},
                message: {}
            };
            editor.config.gwfplugin.font = editor.config.gwfplugin.font || {};
            editor.config.gwfplugin.cancel = editor.config.gwfplugin.cancel || {};
            editor.config.gwfplugin.ok = editor.config.gwfplugin.ok || {};
            editor.config.gwfplugin.message = editor.config.gwfplugin.message || {};
            this.fontLabel = editor.config.gwfplugin.font.label || 'GoogleWebFonts';
            this.popup = this.popUp(editor.config);
            var self = this;
            CKEDITOR.on('instanceReady', function (ev) {
                if (!ev.editor.ui.instances.Font.gwfInjected) {
                    var c = ev.editor.ui.instances.Font.onClick;
                    ev.editor.ui.instances.Font.onClick = function (b) {
                        if (b === self.fontLabel) {
                            self.popup.style.display = 'block';
                            self.popup.style.top = (window.innerHeight - 200) / 2 + 'px';
                            self.popup.style.left = (window.innerWidth - 150) / 2 + 'px';
                            self.popup.extraClickValue = function (v) {
                                var links = ev.editor.editable().$.getElementsByTagName('link');
                                var included = false;
                                for (var i = 0; i < links.length; i++) {
                                    if (links[i].getAttribute('href') === 'https://fonts.googleapis.com/css?family=' + v) {
                                        included = true;
                                        break;
                                    }
                                }
                                if (!included) {
                                    var css = document.createElement('link');
                                    css.setAttribute('type', 'text/css');
                                    css.setAttribute('rel', 'stylesheet');
                                    css.setAttribute('href', 'https://fonts.googleapis.com/css?family=' + v);
                                    ev.editor.editable().$.appendChild(css);
                                }
                                ev.editor.applyStyle(new CKEDITOR.style({
                                    element: 'span',
                                    attributes: { },
                                    styles: { 'font-family': v}
                                }));
                            }
                        } else {
                            c.call(ev.editor.ui.instances.Font, b);
                        }
                    };
                    ev.editor.ui.instances.Font.gwfInjected = true;
                }
            })
        },
        popUp: function (config) {
            var fontNames = ['Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alice', 'Alike', 'Almendra SC', 'Amarante', 'Angkor', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 
			'Atomic Age', 'Aubrey', 'Audiowide', 'Averia Serif Libre', 'Bad Script', 'Balthazar', 'Bangers', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One',
			'Bilbo', 'Bilbo Swash Caps', 'Bitter', 'Black Ops One', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Calligraffitti',
			'Cambo', 'Candal', 'Cantarell', 'Cantata One', 'Carter One', 'Caudex', 'Chewy', 'Chicle', 'Chivo', 'Cinzel', 'Cinzel Decorative', 'Clicker Script', 'Coda', 
			'Coda Caption', 'Codystar', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Crafty Girls', 'Creepster', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 
			'Damion', 'Dancing Script', 'Dangrek', 'Dawning of a New Day', 'Days One', 'Delius', 'Delius Swash Caps', 'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 
			'Domine', 'Donegal One', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Economica', 'Electrolize', 'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Engagement', 'Englebert', 
			'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script', 'Ewert', 'Exo', 'Exo 2', 'Expletus Sans', 'Fanwood Text', 'Fascinate',
			'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint', 'Forum', 'Francois One', 'Freckle Face', 'Fredericka the Great', 'Fredoka One', 'Freehand', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 
			'Gafata', 'Galdeano', 'Goblin One', 'Gochi Hand', 'Gorditas', 'Goudy Bookletter 1911', 'Graduate', 
			'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Habibi', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman', 'Happy Monkey', 'Headland One', 'Henny Penny', 
			'Herr Von Muellerhoff', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 
			'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Irish Grover', 'Istok Web', 'Italiana', 'Italianno', 'Jacques Francois', 'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 
			'Josefin Sans', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Kameron', 'Kantumruy', 'Karla', 'Kaushan Script', 'Kavoon', 'Kdam Thmor', 'Keania One', 'Kelly Slab', 'Kenia', 'Khmer', 
			'Kite One', 'Knewave', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 
			'Lekton', 'Lemon', 'Libre Baskerville', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 
			'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps', 'Magra', 'Maiden Orange', 'Mako', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 
			'Marvel', 'Mate', 'Mate SC', 'Maven Pro', 'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Metal', 'Metal Mania', 'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 
			'Modern Antiqua', 'Molengo', 'Molle', 'Monda', 'Monofett', 'Monoton', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedfort', 'Muli', 'Mystery Quest', 'Neucha', 
			'Neuton', 'New Rocker', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Noto Sans', 'Noto Serif', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 
			'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script', 'Oleo Script Swash Caps', 'Open Sans', 'Open Sans Condensed', 
			'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald', 'Over the Rainbow', 'Overlock', 'Overlock SC', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 
			'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Paprika', 'Paytone One', 'Peralta', 'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 
			'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball', 'Pontano Sans', 'Port Lligat Sans', 'Port Lligat Slab', 'Prata', 'Preahvihear', 'Prosto One', 'Puritan', 'Purple Purse', 
			'Quando', 'Quantico', 'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Raleway', 'Raleway Dots', 'Rambla', 'Rammetto One', 
			'Ranchers', 'Rancho', 'Rationale', 'Redressed', 'Reenie Beanie', 'Roboto', 'Roboto Condensed', 'Ropa Sans', 'Rosario', 'Rosarivo', 'Rouge Script', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 
			'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sail', 'Salsa', 'Sanchez', 'Seymour One', 
			'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony', 'Sirin Stencil', 'Six Caps', 
			'Skranji', 'Slackey', 'Smokum', 'Smythe', 'Sniglet', 'Special Elite', 
			'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Stalemate', 'Stalinist One', 'Stardos Stencil', 'Supermercado One', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 
			'Tauri', 'Telex', 'Tenor Sans', 'Text Me One', 'The Girl Next Door', 'Tienne', 'Tinos', 'Titan One', 'Titillium Web', 'Ubuntu', 'Ubuntu Condensed', 'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 
			'Unica One', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Vampiro One', 'Varela', 'Varela Round', 'Vast Shadow', 'Vibur', 'Vidaloka', 'Voltaire', 'Waiting for the Sunrise', 'Wallpoet', 
			'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Yanone Kaffeesatz', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Zeyada'];
            var css = document.createElement('link');
            css.setAttribute('type', 'text/css');
            css.setAttribute('rel', 'stylesheet');
            css.setAttribute('href', CKEDITOR.basePath + 'plugins/ckeditor-gwf-plugin/style.css');
            document.body.appendChild(css);

            var popup = document.createElement('div');
            popup.className = 'popup';
            popup.id = 'gwf-popup';
            var cancel = document.createElement('button');
            cancel.className = config.gwfplugin.cancel.className || 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only widget_btn design-btn btn-cancel ui-state-active ui-state-focus';
            cancel.innerHTML = config.gwfplugin.cancel.label || 'Cancel';
            cancel.onclick = function () {
                popup.style.display = 'none';
            };
            var message = document.createElement('span');
            message.innerHTML = config.gwfplugin.message.text || '<h5>Enter Font-Name from Google Web Fonts:</h5>';
            var input = document.createElement('input');
            input.setAttribute('list', 'fontNames');
            input.setAttribute('id', 'fontNamesInput');
            var dataList = document.createElement('datalist');
            dataList.setAttribute('id', 'fontNames');
            var dataListFallback = document.createElement('select');
            dataList.appendChild(dataListFallback);
            fontNames.forEach(function (e) {
                var option = document.createElement('option');
                option.setAttribute('value', e);
                option.textContent = e;
                dataList.appendChild(option);
                dataListFallback.appendChild(option);
            });
            dataListFallback.onchange = function () {
                input.value = dataListFallback.value;
            };
            var okButton = document.createElement('button');
            okButton.innerHTML = config.gwfplugin.ok.label || 'Apply Font';
            okButton.className = config.gwfplugin.ok.className || 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only widget_btn design-btn ui-state-focus';
            okButton.onclick = function (e) {
                popup.extraClickValue(input.value);
                input.value = '';
                cancel.onclick(e);
            };
            popup.appendChild(message);
            popup.appendChild(input);
            popup.appendChild(dataList);
            popup.appendChild(okButton);
            popup.appendChild(cancel);
            document.body.appendChild(popup);
            return popup;
        }

    });

