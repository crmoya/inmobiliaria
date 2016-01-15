function replaceAll( text, busca, reemplaza ){
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca,reemplaza);
    return text;
}

$(document).ready(function(e){
    function contains(array,x){
        for(i=0;i<array.length;i++){
            if(array[i]==x){
                return true;
            }
        }
        return false;
    }
});
