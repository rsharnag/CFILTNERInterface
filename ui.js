/**
 * Created by Rahul Sharnagat on 19/1/14.
 */
function  getSelectedHTMLText(){
    var html="";
    if (typeof window.getSelection!="undefined"){
        var sel=window.getSelection();
        if(sel.rangeCount){
            var container=document.createElement("div");
            for(var i= 0,len=sel.rangeCount;i<len;++i){
                container.appendChild(sel.getRangeAt(i).cloneRange());
            }
            html=container.innerHTML;
        }
        else if(typeof document.selection!="undefined"){
            if(document.selection.type=="Text"){
                html=document.selection.createRange().htmlText;
            }
        }
    }
    return html;
}


function surroundSelection(tag){

    if( typeof window.getSelection!="undefined")
    var sel=window.getSelection();
    if(sel.toString().trim()==""){
        bootbox.alert("Please Select a Word first!");
    }
    else{
        if(sel.rangeCount){
            for(var i= 0,len=sel.rangeCount;i<len;++i){
                var range=sel.getRangeAt(i).cloneRange();
                range.surroundContents(tag);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    }
}
function setTag(tagClass){

    var span= document.createElement("span");
    span.className=tagClass;
    span.title=tagClass;
    surroundSelection(span);
}
function unSetTag(){
    var sel = document.getSelection();
    if(sel.toString().trim()==""){
        bootbox.alert("Please select the tagged word first!");
    }else{
        var content = document.getElementById("tsentence").innerHTML;
        var regex = new RegExp('\<span [^\>]*?\>'+sel.toString()+"\</span\>","g");
        document.getElementById("tsentence").innerHTML=content.replace(regex,sel.toString());

    }

}
