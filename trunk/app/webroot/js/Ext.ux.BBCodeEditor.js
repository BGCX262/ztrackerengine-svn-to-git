// vim: ts=4:sw=4:nu:fdc=2:nospell

// config SmilePalette {{{
Ext.SmilePalette = function(config){
    Ext.SmilePalette.superclass.constructor.call(this, config);
    this.addEvents(
        'select'
    );

    if(this.handler){
        this.on("select", this.handler, this.scope, true);
    }
};
// }}}

Ext.extend(Ext.SmilePalette, Ext.Component, {
    // Smile palette {{{	
    
    itemCls : "x-panel-body",
    
    value : null,
    clickEvent:'click',
        ctype: "Ext.ColorPalette",

    
    allowReselect : false,

    smiles:[
        {text:':)', image:'/ztracker/img/smiles/smile.gif'},
        {text:';)', image:'/ztracker/img/smiles/wink.gif'}
    ],

    onRender : function(container, position){
        var t = this.tpl || new Ext.XTemplate('<tpl for="."><a href="#" hidefocus="on"><em><img title="{text}" src="{image}"/></em></a></tpl>');
        var el = document.createElement("div");
        el.className = this.itemCls;
        t.overwrite(el, this.smiles);
        container.dom.insertBefore(el, position);
        this.el = Ext.get(el);
        this.el.on(this.clickEvent, this.handleClick,  this, {delegate: "a"});
        if(this.clickEvent != 'click'){
            this.el.on('click', Ext.emptyFn,  this, {delegate: "a", preventDefault:true});
        }
    },

    afterRender : function(){
        Ext.ColorPalette.superclass.afterRender.call(this);
        if(this.value){
            var s = this.value;
            this.value = null;
            this.select(s);
        }
    },
    // TODO: need to refactor this {{{
    handleClick : function(e, t){
        e.preventDefault();
        if(!this.disabled){
            var c = t.className.match(/(?:^|\s)color-(.{6})(?:\s|$)/)[1];
            this.select(c.toUpperCase());
        }
    },

    
    select : function(color){
        color = color.replace("#", "");
        if(color != this.value || this.allowReselect){
            var el = this.el;
            if(this.value){
                el.child("a.color-"+this.value).removeClass("x-color-palette-sel");
            }
            el.child("a.color-"+color).addClass("x-color-palette-sel");
            this.value = color;
            this.fireEvent("select", this, color);
        }
    }
    // }}}
    
});
Ext.reg('smilepalette', Ext.SmilePalette);

//}}}

Ext.menu.SmileItem = function(config){
    Ext.menu.SmileItem.superclass.constructor.call(this, new Ext.SmilePalette(config), config);
    
    this.palette = this.component;
    this.relayEvents(this.palette, ["select"]);
    if(this.selectHandler){
        this.on('select', this.selectHandler, this.scope);
    }
};
Ext.extend(Ext.menu.SmileItem, Ext.menu.Adapter);


Ext.menu.SmileMenu = function(config){
    Ext.menu.SmileMenu.superclass.constructor.call(this, config);
    this.plain = true;
    var ci = new Ext.menu.SmileItem(config);
    this.add(ci);
    
    this.palette = ci.palette;
    
    this.relayEvents(ci, ["select"]);
};
Ext.extend(Ext.menu.SmileMenu, Ext.menu.Menu);

Ext.ux.BBCodeEditor = Ext.extend(Ext.form.Field, {
    enableFormat: true,
    enableSmiles: true,
    enableColors: true,
    enableAlignments: true,
    enableLinks: true,
    enableImages: true,
    enableFont: true,
    createLinkText: 'Please enter the URL for the link:',
    defaultLinkValue: 'http:/'+'/',
    createImageText: 'Please enter the URL for the image:',
    defaultImageValue: 'http:/'+'/',
    fontSizes: [11, 12, 14, 16, 18],
    defaultFont: 11,

    // private properties
    validationEvent: false,
    deferHeight: true,
    initialized: false,
    activated: false,
    onFocus: Ext.emptyFn,
    hideMode: 'offsets',
    defaultAutoCreate: {
        tag: "textarea",
        style: "width:500px;height:300px;",
        autocomplete: "off"
    },

    // private
    initComponent : function(){
        this.addEvents(
            'initialize',
            'activate'
        )
    },

    createFontOptions : function(){
        var buf = [], fs = this.fontSizes, ff;
        for(var i = 0, len = fs.length; i< len; i++){
            ff = fs[i];
            buf.push(
                '<option value="', ff, '"',
                    (this.defaultFont == ff ? ' selected="true">' : '>'),
                    ff, 'px',
                '</option>'
            );
        }
        return buf.join('');
    },
    
    createToolbar : function(editor){
        function btn(id, toggle, handler){
            return {
                itemId: id,
                cls: 'x-btn-icon x-edit-'+id,
                enableToggle: toggle !== false,
                scope: editor,
                handler: handler||editor.relayBtnCmd,
                clickEvent: 'mousedown',
                tooltip: editor.buttonTips[id] || undefined,
                tabIndex: -1
            };
        }

        // create toolbar {{{
        var tb = new Ext.Toolbar({
            renderTo:this.wrap.dom.firstChild
        });

        tb.el.on('click', function(e){
            e.preventDefault();
        });

        if(this.enableSmiles) {
            tb.add('-',
                    {
                    itemId:'smile',
                    cls:'x-btn-icon x-edit-forecolor',
                    clickEvent:'mousedown',
                    tooltip: editor.buttonTips['forecolor'] || undefined,
                    tabIndex:-1,
                    menu : new Ext.menu.SmileMenu({
                        allowReselect: true,
                        focus: Ext.emptyFn,
                        value:false,
                        plain:true,
                        selectHandler: function(cp, color){
                            this.execCmd('forecolor', Ext.isSafari || Ext.isIE ? '#'+color : color);
                            this.deferFocus();
                        },
                        scope: this,
                        clickEvent:'mousedown'
                    })}
            )
        };

        if(this.enableFont && !Ext.isSafari){
            this.fontSelect = tb.el.createChild({
                tag:'select',
                cls:'x-font-select',
                html: this.createFontOptions()
            });
            this.fontSelect.on('change', function(){
                var font = this.fontSelect.dom.value;
                this.relayCmd('fontname', font);
                this.deferFocus();
            }, this);
            tb.add(
                this.fontSelect.dom,
                '-'
            );
        };

        if(this.enableFormat){
            tb.add(
                btn('bold'),
                btn('italic'),
                btn('underline')
            );
        };

        if(this.enableColors){
            tb.add(
                '-', {
                    itemId:'forecolor',
                    cls:'x-btn-icon x-edit-forecolor',
                    clickEvent:'mousedown',
                    tooltip: editor.buttonTips['forecolor'] || undefined,
                    tabIndex:-1,
                    menu : new Ext.menu.ColorMenu({
                        allowReselect: true,
                        focus: Ext.emptyFn,
                        value:'000000',
                        plain:true,
                        selectHandler: function(cp, color){
                            this.execCmd('forecolor', Ext.isSafari || Ext.isIE ? '#'+color : color);
                            this.deferFocus();
                        },
                        scope: this,
                        clickEvent:'mousedown'
                    })
                }, {
                    itemId:'backcolor',
                    cls:'x-btn-icon x-edit-backcolor',
                    clickEvent:'mousedown',
                    tooltip: editor.buttonTips['backcolor'] || undefined,
                    tabIndex:-1,
                    menu : new Ext.menu.ColorMenu({
                        focus: Ext.emptyFn,
                        value:false,
                        plain:true,
                        allowReselect: true,
                        selectHandler: function(cp, color){
                            this.execCmd('backcolor', color);
                            this.deferFocus();
                        },
                        scope:this,
                        clickEvent:'mousedown'
                    })
                }
            );
        };

        if(this.enableAlignments){
            tb.add(
                '-',
                btn('justifyleft'),
                btn('justifycenter'),
                btn('justifyright')
            );
        };

        if(this.enableLinks){
            tb.add(
                '-',
                btn('createlink', false, this.createLink)
            );
        };

        if(this.enableImages){
            tb.add(
                '-',
                btn('createimg', false, this.createImg)
            );
        };
        
        this.tb = tb;
    },
    // }}}

    // private
    onRender : function(ct, position){
        Ext.ux.BBCodeEditor.superclass.onRender.call(this, ct, position);
        this.el.dom.style.border = '0 none';
        if(Ext.isIE){ // fix IE 1px bogus margin
            this.el.applyStyles('margin-top:-1px;margin-bottom:-1px;')
        }
        this.wrap = this.el.wrap({
            cls:'x-html-editor-wrap', cn:{cls:'x-html-editor-tb'}
        });

        this.createToolbar(this);

        if(!this.width){
            this.setSize(this.el.getSize());
        }
    },

    // private
    onResize : function(w, h){
        Ext.ux.BBCodeEditor.superclass.onResize.apply(this, arguments);
        if(this.el){
            if(typeof w == 'number'){
                var aw = w - this.wrap.getFrameWidth('lr');
                this.el.setWidth(this.adjustWidth('textarea', aw));
            }
            if(typeof h == 'number'){
                var ah = h - this.wrap.getFrameWidth('tb') - this.tb.el.getHeight();
                this.el.setHeight(this.adjustWidth('textarea', ah));
            }
        }
    },

    // private used internally
    createLink : function(){
        var url = prompt(this.createLinkText, this.defaultLinkValue);
        if(url && url != 'http:/'+'/'){
            this.relayCmd('createlink', url);
        }
    },

    createImg : function(){
        var url = prompt(this.createImageText, this.defaultImageValue);
        if(url && url != 'http:/'+'/'){
            this.relayCmd('createimg', url);
        }
    },

    // private (for BoxComponent)
    adjustSize : Ext.BoxComponent.prototype.adjustSize,

    // private (for BoxComponent)
    getResizeEl : function(){
        return this.wrap;
    },

    // private (for BoxComponent)
    getPositionEl : function(){
        return this.wrap;
    },

    // private
    initEvents : function(){
        this.originalValue = this.getValue();
    },

    markInvalid : Ext.emptyFn,
    clearInvalid : Ext.emptyFn,

    setValue : function(v){
        Ext.ux.BBCodeEditor.superclass.setValue.call(this, v);
    },

    // private
    deferFocus : function(){
        this.focus.defer(10, this);
    },

    // doc'ed in Field
    focus : function(){
        this.el.focus();
    },

    // private
    initEditor : function(){
        this.initialized = true;
        this.fireEvent('initialize', this);
    },

    // private
    onDestroy : function(){
        if(this.rendered){
            this.tb.items.each(function(item){
                if(item.menu){
                    item.menu.removeAll();
                    if(item.menu.el){
                        item.menu.el.destroy();
                    }
                }
                item.destroy();
            });
        }
    },

    // private
    onFirstFocus : function(){
        this.activated = true;
        this.tb.items.each(function(item){
           item.enable();
        });

        this.fireEvent('activate', this);
    },

    onEditorEvent : function(e){
        this.updateToolbar();
    },

    /**
     * Protected method that will not generally be called directly. It triggers
     * a toolbar update by reading the markup state of the current selection in the editor.
     */
    updateToolbar: function(){

        if(!this.activated){
            this.onFirstFocus();
            return;
        }
        Ext.menu.MenuMgr.hideAll();
    },

    // private
    relayBtnCmd : function(btn){
        this.relayCmd(btn.itemId);
    },

    /**
     * Executes a Midas editor command on the editor document and performs necessary focus and
     * toolbar updates. <b>This should only be called after the editor is initialized.</b>
     * @param {String} cmd The Midas command
     * @param {String/Boolean} value (optional) The value to pass to the command (defaults to null)
     */
    relayCmd : function(cmd, value){
        //this.win.focus();
        this.execCmd(cmd, value);
        this.updateToolbar();
        this.deferFocus();
    },

    /**
     * Executes a Midas editor command directly on the editor document.
     * For visual commands, you should use {@link #relayCmd} instead.
     * <b>This should only be called after the editor is initialized.</b>
     * @param {String} cmd The Midas command
     * @param {String/Boolean} value (optional) The value to pass to the command (defaults to null)
     */
    execCmd : function(cmd, value){
    	if(cmd=='bold') {
   			if(!this.replaceSelectedText(this.el.dom, '[b]', '[/b]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[b]';
    			} else {
    				this.el.dom.value += '[/b]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}    	
    	}
    	if(cmd=='italic') {
   			if(!this.replaceSelectedText(this.el.dom, '[i]', '[/i]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[i]';
    			} else {
    				this.el.dom.value += '[/i]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}    	
    	}      
    	if(cmd=='underline') {
   			if(!this.replaceSelectedText(this.el.dom, '[u]', '[/u]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[u]';
    			} else {
    				this.el.dom.value += '[/u]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}    	
    	}          	
    	if(cmd=='forecolor') {
    		if(value !== false) {
    			if(!this.replaceSelectedText(this.el.dom, '[color=#'+value+']', '[/color]')) {
    				this.el.dom.value += '[color=#'+value+'][/color]';
    			}
    		}
    	}      
    	if(cmd=='backcolor') {
    		if(value !== false) {
    			if(!this.replaceSelectedText(this.el.dom, '[bgcolor=#'+value+']', '[/bgcolor]')) {
    				this.el.dom.value += '[bgcolor=#'+value+'][/bgcolor]';
    			}
    		}
    	}          	
    	if(cmd=='justifyleft') {
   			if(!this.replaceSelectedText(this.el.dom, '[align=left]', '[/align]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[align=left]';
    			} else {
    				this.el.dom.value += '[/align]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}
    	}      
    	if(cmd=='justifycenter') {
   			if(!this.replaceSelectedText(this.el.dom, '[align=center]', '[/align]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[align=center]';
    			} else {
    				this.el.dom.value += '[/align]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}    	
   		}      
    	if(cmd=='justifyright') {
   			if(!this.replaceSelectedText(this.el.dom, '[align=right]', '[/align]')) {
	    		if(this.tb.items.get(cmd).pressed) {
    				this.el.dom.value += '[align=right]';
    			} else {
    				this.el.dom.value += '[/align]';
    			}
   			} else {
   				this.tb.items.get(cmd).toggle(false);
   			}    	
   		}
    	if(cmd=='createlink') {
    		if(value) {
    			if(!this.replaceSelectedText(this.el.dom, '[url='+value+']', '[/url]')) {
    				this.el.dom.value += '[url='+value+']'+value+'[/url]';
    			}
    		}
    	}
    	if(cmd=='createimg') {
    		if(value) {
    			this.el.dom.value += '[img]'+value+'[/img]';
    		}
    	}
    	if(cmd=='fontname') {
    		if(value) {
    			if(!this.replaceSelectedText(this.el.dom, '[size='+value+']', '[/size]')) {
    				this.el.dom.value += '[size='+value+'][/size]';
    			}
    		}
    	}
    },
    
    // private
    replaceSelectedText : function (obj, prefix, suffix){
 		obj.focus();
		if (document.selection) {
   			var s = document.selection.createRange(); 
   			if (s.text) {
     			s.text = prefix + s.text + suffix;
	 			s.select();
	 			return true;
   			}
 		} else if (typeof(obj.selectionStart) == "number") {
   			if (obj.selectionStart!=obj.selectionEnd) {
     			var start = obj.selectionStart;
     			var end = obj.selectionEnd;
				var rs = prefix + obj.value.substr(start,end-start) + suffix;
				obj.value = obj.value.substr(0,start)+rs+obj.value.substr(end);
				obj.setSelectionRange(end,end);
				return true;
   			}
 		}
		return false;
	},
    
    /**
     * Inserts the passed text at the current cursor position. Note: the editor must be initialized and activated
     * to insert text.
     * @param {String} text
     */
    insertAtCursor : function(text){
        if(!this.activated){
            return;
        }
    },

    /**
     * Returns the editor's toolbar. <b>This is only available after the editor has been rendered.</b>
     * @return {Ext.Toolbar}
     */
    getToolbar : function(){
        return this.tb;
    },

    /**
     * Object collection of toolbar tooltips for the buttons in the editor. The key
     * is the command id associated with that button and the value is a valid QuickTips object.
     * For example:
     * @type Object
     */
    buttonTips : {
        bold : {
            title: 'Bold',
            text: 'Make the selected text bold.',
            cls: 'x-html-editor-tip'
        },
        italic : {
            title: 'Italic',
            text: 'Make the selected text italic.',
            cls: 'x-html-editor-tip'
        },
        underline : {
            title: 'Underline',
            text: 'Underline the selected text.',
            cls: 'x-html-editor-tip'
        },
        backcolor : {
            title: 'Text Highlight Color',
            text: 'Change the background color of the selected text.',
            cls: 'x-html-editor-tip'
        },
        forecolor : {
            title: 'Font Color',
            text: 'Change the color of the selected text.',
            cls: 'x-html-editor-tip'
        },
        justifyleft : {
            title: 'Align Text Left',
            text: 'Align selected text to the left.',
            cls: 'x-html-editor-tip'
        },
        justifycenter : {
            title: 'Center Text',
            text: 'Center selected text.',
            cls: 'x-html-editor-tip'
        },
        justifyright : {
            title: 'Align Text Right',
            text: 'Align selected text to the right.',
            cls: 'x-html-editor-tip'
        },
        createlink : {
            title: 'Hyperlink',
            text: 'Make the selected text a hyperlink.',
            cls: 'x-html-editor-tip'
        },
        createimg : {
            title: 'Image',
            text: 'Insert image',
            cls: 'x-html-editor-tip'
        }
    }
});
Ext.reg('bbcodeeditor', Ext.ux.BBCodeEditor);
