var forward = new Class({
    Implements:[new Options,new Events],
    options:{
        isPB:true,
        isDrag:true,
		ppl:70,//每条�?
		maxl:160//总长
    },
    initialize:function(options){
        if(options){
            this.setOptions(options);
        }
		if(this.options.isPB){
                var b=this.BaseDiv();
                this.Resize(b);
        }
		this.MainWin();
    },
    BaseDiv:function(){
        var base = new Element('div',{
            'id':'BaseDiv',
            'styles':{
                'width':$(document.body).getScrollSize().x,
                'height':$(document.body).getScrollSize().y,
                'position':'absolute',
                'top':'0px',
                'left':'0px',
                'opacity':0.1,
                'backgroundColor':'black',
                'z-index':9999
            }
        });
		$$('select').setStyle('visibility','hidden');
        base.inject($(document.body));
        return base;
    },
    MainWin:function(){
        var win = new Element('div',{
            'id':'win_main',
            'class':'main_win',
            'styles':{
                'width':'351px',
                'height':'251px',
                'position':'absolute',
                'z-index':10000,
	        'background-color':'white'
            }
        });
        win.inject($(document.body));
        win.setStyles({
            'top':($(document.body).getScroll().y+200)+'px',
            'left':($(document.body).getScrollSize().x - win.getStyle('width').toInt())/2 + 'px'
        });
        var html='<div class="main">'+
            '<div id="win_hand" class="main_title f12">'+
                '<span><strong>转发到我的微博</strong></span>'+
                '<span class="close" style="cursor:default"><strong>X</strong></span>'+
            '</div>'+
            '<div id="count_num">还可以输入<span id="num_span">160</span>个字</div>'+
            '<form action="ss" method="post">'+
                '<div id="div_area">'+
                    '<textarea id="area_content" style="width:313px;height: 70px;"></textarea><br/>'+
                    '<div id="div_area_input"><input  type="checkbox" name="" style="vertical-align: middle"/>&nbsp;<span >同时评论给：义薄云天</span></div>'+
                '</div>'+
                '<div class="clr"></div>'+
                '<div id="div_button">'+
                    '<input type="submit"value="转发"/>&nbsp;&nbsp;'+
                    '<input type="button" value="取消" id="cancel"/>'+
                '</div>'+
            '</form>'+
        '</div>';
        win.setProperty('html',html);
        this.Win2E();
    },

    Win2E:function(){
        var Class = this;
        if($('win_main')){
            $('win_main').getElements('span[class=close]')[0].addEvent('click',function(){
                Class.Close($('win_main'));
            });
            $('cancel').addEvent('click',function(){
                Class.Close($('win_main'));
            });
			$('win_main').addEvent('keydown',function(){
				   var s=$('area_content').value.length+1;
				   if(s>Class.options.maxl) $('area_content').value=$('area_content').value.substr(0,Class.options.maxl-1);
				   else $('num_span').innerHTML=s+"/"+Class.options.maxl;
			})
            if(Class.options.isDrag){
                $('win_hand').setStyle('cursor','move');
                Class.DragObj($('win_main'),$('win_hand'));
            }
        }
    },
    Close:function(el){
        if($('BaseDiv')){
            this.Destroy($('BaseDiv'));
        }
        this.Destroy(el);
        $$('select').setStyle('visibility','');
    },
    DragObj:function(el,hand){
        new Drag(el,{
            'handle':hand,
            'limit':{
                x: [0,$(document.body).getScrollSize().x-el.getStyle('width').toInt()],
                y: [0,$(document.body).getScrollSize().y-el.getStyle('height').toInt()]
            }
        });
    },
    Destroy:function(el){
        if(el){
            el.destroy();
        }
    },
    Resize:function(el){
        $(window).addEvent('resize',function(){
            el.setStyles({
                'width' :$(document.body).getScrollSize().x,
                'height':$(document.body).getScrollSize().y
            });
        });
    }

});


