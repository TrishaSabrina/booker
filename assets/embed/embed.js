function initializeEmbed() {
    const c = document.querySelector('.embed-container');
    if (c !== undefined) {
      const u = c.getAttribute('data-url');
      const s = c.getAttribute('data-slug');
      if(s !== undefined && s.length>1){
        c.setAttribute('style','width:100%;min-height:400px;border:none;background:none transparent;position:relative;left:0;top:0;')
//        c.setAttribute('class', 'embed-container ');
        const d = document.createElement('div');
        const f = document.createElement('div');
        d.setAttribute('style','width:100%;height:100%;position:absolute;left:0;top:0;padding:0;z-index:980;background:none');
        f.setAttribute('style','width:120px;height:65px;display:block;border:none;background:none;position:absolute;top:30%;left:50%;transform:translate(-50%,-50%);');
        f.innerHTML = `<img style='width:100%;height:100%;border:none;padding:0;margin:0;' src='data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(245,245,245,0.85); display: block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
  <rect x="19" y="26.5" width="12" height="47" fill="%230a69aa">
    <animate attributeName="y" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="14.75;26.5;26.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.125s"></animate>
    <animate attributeName="height" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="70.5;47;47" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.125s"></animate>
  </rect>
  <rect x="44" y="26.5" width="12" height="47" fill="%2307abcc">
    <animate attributeName="y" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="17.6875;26.5;26.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.0625s"></animate>
    <animate attributeName="height" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="64.625;47;47" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.0625s"></animate>
  </rect>
  <rect x="69" y="26.5" width="12" height="47" fill="%2391bcc6">
    <animate attributeName="y" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="17.6875;26.5;26.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
    <animate attributeName="height" repeatCount="indefinite" dur="0.625s" calcMode="spline" keyTimes="0;0.5;1" values="64.625;47;47" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
  </rect>
  </svg>' />`;
        d.appendChild(f);
        c.appendChild(d);
        const i = document.createElement('iframe');
        i.src=u+'booking/'+ s +'?embed=true';
        i.style='z-index:910; height:700px';
        i.width='100%';i.height='100%';i.frameBorder=0;i.scrolling='yes'; 
        i.setAttribute('allowtransparency','true');
        i.setAttribute('data-isloaded','0');
        i.innerHTML = 'Your browser does not support iframes.';
        c.appendChild(i);
        window['j']=0;
        window.addEventListener("message", receiveMessage);

        // this method may need improvements
        function receiveMessage(ev)
        {
          const myMsg = ev.data;
          if( myMsg == '1' ){
              i.setAttribute('data-isloaded','1')
              $("#myiframe").prop('data-isloaded', '1');
          }else if( myMsg.length>2 && myMsg.substr(0,2) == '2.'){
            const newHeight= parseInt(myMsg.substr(2))+'px';
            i.style.height = newHeight;
          }else if( myMsg.length>2 && myMsg.substr(0,2) == '3.'){
            const newWidth= parseInt(myMsg.substr(2))+'px';
            //i.style.width = newWidth;
          }
        }
        window['k'] = window.setInterval(function(){
          if(window['j']>30){
            c.removeChild(d);
            if(window['k'] !== undefined){
              clearInterval(window['k']);
            }
          }else{
            const isloaded = i.getAttribute('data-isloaded');
            if(isloaded !== undefined && parseInt(isloaded) == 1){
              c.removeChild(d);
              clearInterval(window['k']);
            }
          }
          window['j'] += 1;
        }, 200)

      }else{
        console.log('error in embed code');
      }
    }else{
      console.log('cant access embed container');
    }
}
window.addEventListener('load',initializeEmbed, false);
