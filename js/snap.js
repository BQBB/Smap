var counter=0;

function check(link,totla)
{

if(document.querySelector('html').clientWidth<768){
    var width=screen.width-89;
    document.querySelector('video').style.width=width+"px";
    document.querySelector('img').style.width=width+"px";
    document.querySelector('button').style.width=(width+55)+"px"
}

    document.querySelector('button').innerText="Next";
    if(counter<totla)
    {
        if(link.match('mp4'))
        {
            document.querySelector('video').setAttribute('src',link);
            document.querySelector('video').removeAttribute('hidden');
            document.querySelector('img').setAttribute('hidden','');
            counter+=1;
        }
        else
        {
            document.querySelector('img').setAttribute('src',link);
            document.querySelector('img').removeAttribute('hidden');
            document.querySelector('video').setAttribute('hidden','');
            counter+=1;
        }
    }
}