Ext.grid.SmartCheckboxSelectionModel = Ext.extend(Ext.grid.RowSelectionModel, {
    header: '<div id="x-grid3-hd-checker" class="x-grid3-hd-checker"></div>',
    width: 20,
    sortable: false,
    menuDisabled:true,
    fixed:true,
    id: 'checker',
    dataIndex: '',



    // private

    initEvents : function(){
        Ext.grid.SmartCheckboxSelectionModel.superclass.initEvents.call(this);

        this.grid.on('render', function(){
            var view = this.grid.getView();
            view.mainBody.on('mousedown', this.onMouseDown, this);
            Ext.fly(view.innerHd).on('mousedown', this.onHdMouseDown, this);
        }, this);        

        this.rowNav.disable();

        this.rowNav2 = new Ext.KeyNav(this.grid.getGridEl(), {
            "up" : function(e){
                if(!e.shiftKey){
                    this.selectPreviousChecked(e.shiftKey);
                }else if(this.last !== false && this.lastActive !== false){
                    var last = this.last;
                    this.selectRangeChecked(this.last, this.lastActive-1);
                    this.grid.getView().focusRow(this.lastActive);
                    if(last !== false){
                        this.last = last;
                    }
                }else{
                    this.selectFirstRow();
                    this.toggleChecked(0, true);
                }
            },

            "down" : function(e){
                if(!e.shiftKey){
                    this.selectNextChecked(e.shiftKey);
                }else if(this.last !== false && this.lastActive !== false){
                    var last = this.last;
                    this.selectRangeChecked(this.last, this.lastActive+1);
                    this.grid.getView().focusRow(this.lastActive,true);
                    if(last !== false){
                        this.last = last;
                    }
                }else{
                    this.selectFirstRow();
                    this.toggleChecked(0, true);
                }
            },
            scope: this
        });      

        if (this.grid.store){
            this.grid.store.on('load', function(p){
                var t = Ext.get('x-grid3-hd-checker');
                if(t != null){
                    if(t.dom.className == 'x-grid3-hd-checker' && Ext.state.Manager.loaded){
                        var hd = Ext.fly(t.dom.parentNode);
                        var isChecked = hd.hasClass('x-grid3-hd-checker-on');
                        if(isChecked){
                            hd.addClass('x-grid3-hd-checker-on');
                            this.selectAll();
                            this.selectAllChecked(true);
                        }

                    }
                }
                  var dataIndex = this.grid.getSelectionModel().dataIndex; // the dataIndex for the selectionModel
                  var count = this.grid.store.getCount();
                for(var i = 0, len = count; i < len; i++){
                    var dataIndexValue = p.data.items[i].data[dataIndex]; // the value of the dataIndex for each row
                    var isSelected = this.isSelected(i);
                    if((dataIndexValue == true || isSelected) && !Ext.state.Manager.loaded){
                        this.grid.getSelectionModel().selectRow(i, true);
                    }
                    else if(isSelected){
                        this.toggleChecked(i, true);
                    }
                    else{
                        this.toggleChecked(i, false);
                    }
                }
            }, this);
        }
    },

       
    toggleChecked : function(rowIndex, c){
        if(this.locked) return;
           var record = this.grid.store.getAt(rowIndex);
        if(c === true){
            // Check
               record.set(this.dataIndex, true);
           }else if(c === false){
               // Uncheck
               record.set(this.dataIndex, false);
           }else{
               // Toggle checked / unchecked
               record.set(this.dataIndex, !record.data[this.dataIndex]);
           }
    },

    
    selectAllChecked : function(c, e){
        if(this.locked) return;
         var count = this.grid.store.getCount();
        for(var i = 0, len = count; i < len; i++){
            if(c){
                if(i !== e){
                    this.toggleChecked(i, true);
                }
            }else{
                if(i !== e){
                    this.toggleChecked(i, false);
                }
            }
        }            
    },

    clearChecked : function(fast){
        if(this.locked) return;
        if(fast !== true){
            var count = this.grid.store.getCount();
            for(var i = 0, len = count; i < len; i++){
                var isSelected = this.isSelected(i);
                if(!isSelected){
                    this.toggleChecked(i, false);
                }
            }
        }else{
            this.selectAllChecked(false);
        }
        this.last = false;
    },    

    selectRangeChecked : function(startRow, endRow, keepExisting){
        if(this.locked) return;
        if(!keepExisting){
            this.clearSelections();
            this.clearChecked();
        }    

        if(startRow <= endRow){
            for(var i = startRow; i <= endRow; i++){
                if(this.grid.store.getAt(i)){
                    this.toggleChecked(i, true);
                    this.selectRow(i, true);
                }
            }
        }else{
            for(var i = startRow; i >= endRow; i--){
                if(this.grid.store.getAt(i)){
                    this.toggleChecked(i, true);
                    this.selectRow(i, true);
                }
            }
        }    
    },

    selectPreviousChecked : function(keepExisting){
        if(this.hasPrevious()){
            this.selectRow(this.last-1, keepExisting);
            this.grid.getView().focusRow(this.last);            
            this.toggleChecked(this.last, true);
            this.selectAllChecked(false, this.last);
            return true;
        }
        return false;
    },


    selectNextChecked : function(keepExisting){
        if(this.hasNext()){
            this.selectRow(this.last+1, keepExisting);
            this.grid.getView().focusRow(this.last);            
            this.toggleChecked(this.last, true);
            this.selectAllChecked(false, this.last);
            return true;
        }
        return false;
    },    


    handleMouseDown : function(g, rowIndex, e){
        if(e.button !== 0 || this.isLocked()){
            return;
        };
        var view = this.grid.getView();
        var record = this.grid.store.getAt(rowIndex);
        if(e.shiftKey && this.last !== false){
            var last = this.last;
            this.selectRange(last, rowIndex, e.ctrlKey);
            this.selectRangeChecked(last, rowIndex, e.ctrlKey);
            this.last = last; // reset the last
            view.focusRow(rowIndex);
        }else{
//            this.toggleChecked(rowIndex);
            var isChecked = record.data[this.dataIndex];
            var isSelected = this.isSelected(rowIndex);
         
            if (isSelected){
                this.deselectRow(rowIndex);
//                this.toggleChecked(rowIndex, false);
            }else{
                this.selectRow(rowIndex, true);
//                this.toggleChecked(rowIndex, true);
                view.focusRow(rowIndex);
            }
        }
    },

    onMouseDown : function(e, t){
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var view = this.grid.getView();
            var rowIndex = view.findRowIndex(t);
            var isSelected = this.isSelected(rowIndex);
            if (isSelected){
                this.deselectRow(rowIndex);
                this.toggleChecked(rowIndex, false);
            }else{

                this.selectRow(rowIndex, true);
                this.toggleChecked(rowIndex, true);
                view.focusRow(rowIndex);
            }
        }

           Ext.state.Manager.setProvider(new Ext.state.CookieProvider());            
           Ext.state.Manager.loaded = true;            
    },

    onHdMouseDown : function(e, t){
        if(t.className == 'x-grid3-hd-checker'){
            e.stopEvent();
            var hd = Ext.fly(t.parentNode);
            var isChecked = hd.hasClass('x-grid3-hd-checker-on');
            if(isChecked){
                hd.removeClass('x-grid3-hd-checker-on');
                this.clearSelections();
                this.clearChecked(true); // the true param enables fast mode
            }else{
                hd.addClass('x-grid3-hd-checker-on');
                this.selectAll();
                this.selectAllChecked(true);
            }
        }

        // Load the state manager
        Ext.state.Manager.setProvider(new Ext.state.CookieProvider());            
        Ext.state.Manager.loaded = true;            
    },

    
    renderer : function(v, p, record){
        p.css += ' x-grid3-check-col-td'; 
        return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'"></div>';
    }

}); 

