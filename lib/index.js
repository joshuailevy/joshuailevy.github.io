/* global sharkViewer */
let s = null;

// let mdata;
// function readSwcFile(e) {
//  const f = e.target.files[0];
//     console.log(f)

//     // Construct a file

//   if (f) {
//     const r = new FileReader();
//     r.onload = (e2) => {
//       const swcTxt = e2.target.result;
//       console.log(e2.target.result)
//       const  swc = sharkViewer.swcParser(swcTxt);
//       if (Object.keys(swc).length > 0) {
//         s.loadNeuron('foo', '#ff0000', swc);
//         s.render();
//       } else {
//         alert("Please upload a valid swc file.");
//       }
//     };
//     r.readAsText(f);
//   } else {
//     alert("Failed to load file");
//   }
// }

// function readObjFile(e) {
//   const file = e.target.files[0];
//   if (file) {
//     const reader = new FileReader();
//     reader.onload = (event) => {
//       const objText = event.target.result;
//       s.loadCompartment('foo', '#C0C0C0', objText);
//       s.render();
//     };
//     reader.readAsText(file);
//   }
// }


function FileHelper()

{
    FileHelper.readStringFromFileAtPath = function(pathOfFileToReadFrom)
    {
        var request = new XMLHttpRequest();
        request.open("GET", pathOfFileToReadFrom, false);
        request.send(null);
        var returnValue = request.responseText;

        return returnValue;
    }
}


window.onload = () => {
  const swc = sharkViewer.swcParser(document.getElementById("swc").text);
  // mdata = JSON.parse(document.getElementById("metadata_swc").text);
  s = new sharkViewer.default({
    animated: false,
    mode: 'particle',
    dom_element: document.getElementById('container'),
    showAxes: 0,
    // maxVolumeSize: 5000,
    cameraChangeCallback: (data) => {}
  });
  window.s = s;
  s.init();
  s.animate();
  const swc2 = sharkViewer.swcParser(document.getElementById("swc2").text);

  // add all of the neurons we want. 
  let neurons = ['2069320377.swc','2100670439.swc','2131696932.swc','2132037566.swc','2163102697.swc','5813024340.swc'];
  let colors = ['#ff0000','#0000ff','#0000ff','#0000ff','#ff0000','#ff0000']
  // let url = "2131696932.swc";
  var i1;
  let baseStr = 'skeletons/';
  for (i1=0;i1<neurons.length;i1++){
    let url = baseStr.concat(neurons[i1]);
    let color1 = colors[i1];
    // console.log(colors[i1])
    // console.log('#C0C0C0')
    console.log(i1)
    fetch(url).then(function(response) {
  response.text().then(function(text) {


    const  swc = sharkViewer.swcParser(text);
  // console.log(neurons[i1],i1)
  // console.log(url,i1)
    s.loadNeuron(neurons[i1],color1, swc,true);

    });
  });
};
  // add all of the rois
let rois  = ["AL(R).obj","LH(R).obj"];
let baseStr2 = 'rois/';
for (i1=0;i1<rois.length;i1++){
let roiurl = baseStr2.concat(rois[i1])

fetch(roiurl).then(function(response) {
  response.text().then(function(text) {
    // console.log(text)
  s.loadCompartment(rois[i1], '#C0C0C0', text);
  });
});
};

  s.render();
};
