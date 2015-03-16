var ghost;
var surface;

var alpha = 0.75;
var offset = 0;
var delta = 0.02;
var padding = 20;

function drawCanvas() {
  surface = document.getElementById("spoopyGhost");

  if(surface.getContext) {
    ghost = new Image();
    ghost.onload = loadingComplete;
    ghost.src="/static/img/ghost.png";
  }
}

function loadingComplete() {
    setInterval(loop, 25);
}

function loop() {
   var surfaceContext = surface.getContext('2d');
   surfaceContext.clearRect(0,0,surface.width,surface.height);
   surfaceContext.globalAlpha = alpha;

   offset = (offset+delta) % (Math.PI * 2);
   surfaceContext.drawImage(ghost, 0, (padding/2)+(padding * Math.sin(offset)));
}
