Ext.onReady(function() {
    
    var desc1 = new Array();
    desc1[0] = "[b]Название:[/b] Название фильма...\n[b]Оригинальное название:[/b] Name film...\n[b]Год выпуска:[/b] \n[b]Жанр:[/b] \n[b]Выпущено:[/b] \n[b]Режиссер:[/b] \n[b]В ролях:[/b]";
    desc1[1] = "[b]Исполнитель:[/b] Имя\n[b]Альбом:[/b] Имя альбома\n[b]Год выпуска:[/b] 0000\n[b]Жанр:[/b] Поп,Рок,Техно и тп...";
    desc1[2] = "[b]Название:[/b] Название\n[b]Оригинальное название:[/b] Name\n[b]Год выпуска:[/b] 2006\n[b]Жанр:[/b] 3D / 3d Person / Action/ Shooter / Racing / FPS\n[b]Разработчик:[/b] \n[b]Выпущено:[/b] \n[b]Язык:[/b] Русский";
    desc1[3] = "[b]Название:[/b] «Название книги» Автор\n[b]Оригинальное название:[/b] «Name book» Author\n[b]Издательство:[/b] Название издательства\n[b]Озвучивает:[/b] Имя\n[b]Год издания аудио книги:[/b] 0000\n[b]Жанр:[/b] Аудио книга, Радиоспектакль\n[b]Язык:[/b] только для книг на языке оригинала (кроме русского)";
    desc1[4] = "Ох извините шаблона [ Программы ] пока нет...";

    desc2 = new Array();
    desc2[0] = "[b]О фильме:[/b] Краткое описание фильма...";
    desc2[1] = "[b]Tрэклист:[/b] Список композиций...";
    desc2[2] = "[b]Об игре:[/b] Краткое описание Игры ...";
    desc2[3] = "[b]Описание:[/b] Краткая аннотация к книге...";
    desc2[4] = "[b]О программе:[/b] ";

    desc3 = new Array();
    desc3[0] = "[b]Качество:[/b] DVDRip, DVD, HDTVRip, TV/SATRip, VHSRip\n[b]Видео:[/b] XviD, DivX, 808 Кбит/с, 640x272\n[b]Аудио:[/b] MP3, 160 Кбит/с \n[b]Размер:[/b] 600 МБ, 1.4 ГБ \n[b]Продолжительность:[/b] 01:39:43\n[b]Перевод:[/b] Профессиональный, Дублированный, Любительский, Одноголосый, Двухголосый";
    desc3[1] = "[b]Аудио:[/b] MP3, 192 Кбит/с\n[b]Размер:[/b] 600 МБ, 1.4 ГБ\n[b]Продолжительность:[/b] 00:00:00";
    desc3[2] = "[b][u][color=green]Минимальные системные требования:[/u][/b][/color]\n[b]Операционная система:[/b] Windows 2000/XP\n[b]Процессор:[/b] \n[b]Память:[/b] МБ\n[b]Видеокарта:[/b] \n[b]Аудиокарта:[/b] \n[b]Свободное место на ЖД:[/b] МБ/ГБ\n[b]CD-привод:[/b] 8х";
    desc3[3] = "[b]Аудио:[/b] WMA, MP3, 96 Кбит/сек, 44 кГц, стерео\n[b]Размер:[/b] 635 МБ, 1.20 ГБ\n[b]Продолжительность:[/b] 29:55:41";
    desc3[4] = "Ох извините шаблона [ Программы ] пока нет...";

    desc4 = new Array();
    desc4[0] = "[img]линккартинки[/img] [img]линккартинки[/img] \n[img]линккартинки[/img] [img]линккартинки[/img]";
    desc4[1] = "";
    desc4[2] = "[img]линккартинки[/img] [img]линккартинки[/img] \n[img]линккартинки[/img] [img]линккартинки[/img]";
    desc4[3] = "[img]линккартинки[/img]\nРецензия\nОфициальный сайт писателя";
    desc4[4] = "Ох, извините шаблона [ Программы ] пока нет...";

    var cat_store = new Ext.data.JsonStore({
        url:"getcats",
        root:"categories",
        fields:[{name:'name'}, {name:'id'}]
    });

    var ut_store = new Ext.data.JsonStore({
        url:"getuptypes",
        root:"utypes",
        fields:[{name:'name'}, {name:'id'}]
    });

    var tb = new Ext.Toolbar();
    tb.render('toolbar');
    tb.add({
        text:'Кино/Мульт',
        handler: insTemplate
        },{
        text: 'Музыка',
        handler: insTemplate
        },{
        text: 'Игры',
        handler: insTemplate
        },{
        text: 'Аудио книги',
        handler: insTemplate
        },{
        text: 'Программы',
        handler: insTemplate
        });

    var uploadeditor = new Ext.form.FormPanel({
        renderTo:'uploadeditor',
        bodyStyle: 'padding:5px 5px 0',
        url:'doupload',
        frame: true,
        width: 'auto',
        baseCls:'x-plain',
        labelWidth:125,
        defaults: { anchor:'100%' },
        defaultType:'textfield',
        fileUpload:true,


        items:[tb, {
            fieldLabel: 'Название',
            name: 'data[Torrent][name]',
            anchor:'100%',
            allowBlank:false,
        },{
            fieldLabel: 'Торрент файл',
            name: 'torrentFile',
            inputType: 'file',
            allowBlank:false,
        },{
            fieldLabel: 'Инфо файл',
            name: 'torrentNFO',
            inputType: 'file',
            allowBlank:false,
        }, screenshot = new Ext.form.TextField({
            id:'screenshot',
            fieldLabel: 'Основной сриншот',
            name: 'data[Torrent][image1]',
            allowBlank:false,
        }), ds1 = new Ext.form.TextArea({
            fieldLabel: 'Предварительное<br/>описание*',
            name: 'data[Torrent][descr1]',
            height:120,
            allowBlank:false,
        }), ds2 = new Ext.form.TextArea({
            fieldLabel: 'Описание*',
            name: 'data[Torrent][descr2]',
            allowBlank:false,
            height:120,
        }), ds3 = new Ext.form.TextArea({
            fieldLabel: 'Технические<br/>данные*',
            name: 'data[Torrent][descr3]',
            height:120,
            allowBlank:false,
        }), ds4 = new Ext.form.TextArea({
            fieldLabel: 'Скриншоты,<br/>примечания',
            name: 'data[Torrent][descr4]',
            height:120,
        }), new Ext.form.ComboBox({
                fieldLabel: 'Категория',
                id: 'category',
                name: 'category',
                hiddenName: 'data[Torrent][category]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: cat_store,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите категорию...',
                selectOnFocus:true,
                allowBlank:false,
                loadingText:"Загрузка категорий",
                style:"text-align:left;",
                width:200,
            }),
         new Ext.form.ComboBox({
                fieldLabel: 'Тип раздачи',
                id: 'free_type',
                name: 'free_type',
                hiddenName: 'data[Torrent][free_type]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: ut_store,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите тип раздачи ...',
                selectOnFocus:true,
                allowBlank:false,
                loadingText:"Загрузка раздачь",
                style:"text-align:left;",
                width:200,
            })

        ],

        buttons:[{
            text:'Загрузить',
            handler: saveHandler,
        },{
            text:'Прелварительный просмотр',
            handler: previewHandler,
        }]
    })

    function insTemplate(btn, e)
    {
        var sIdx = 0;
        if(btn.text == 'Музыка') sIdx = 1;
        if(btn.text == 'Игры') sIdx = 2;
        if(btn.text == 'Аудио книги') sIdx = 3;
        if(btn.text == 'Программы') sIdx = 4;
        ds1.setValue(desc1[sIdx]);
        ds2.setValue(desc2[sIdx]);
        ds3.setValue(desc3[sIdx]);
        ds4.setValue(desc4[sIdx]);
    }

    function previewHandler()
    {
        if(!Ext.get('preview_window'))
        {
            Ext.Ajax.request({
                waitMsg: 'Please wait...',
                url: '/js/preview_upload.js',
                params: {},
                success: function(response) {
                    try {
                        eval(response.responseText);
                    } catch(e) {
                        Ext.MessageBox.alert('Error','Can not load preview window. <br /><b>' + e + '</b>');
                    }
                },
               failure: function(response) {
                   Ext.MessageBox.alert('Error','Can not load preview window');
               }
            })
        }
    }

    function saveHandler()
    {
        uploadeditor.getForm().submit();
    }

    uploadeditor.on('actioncomplete', function() { window.location = '/torrents' });
    uploadeditor.render(document.getElementById('uploadeditor'));
});
