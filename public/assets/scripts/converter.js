const scale1=document.getElementById('scale1');
const scale2=document.getElementById('scale2');
const convertBtn=document.getElementById('btn-convert');
const distance=document.getElementById('distance');
const multiplicator=document.getElementById('multiplicator');
const scale1Dist=document.getElementById('scale1-dist');
const scale2Dist=document.getElementById('scale2-dist');
const calcBtn=document.getElementById('btn-calc');

const convert=()=>{
    const s1=parseInt(scale1.value);
    const s2=parseInt(scale2.value);
    const result=(s1/s2)*100;
    document.getElementById('result').textContent=result.toFixed(0);
}

const calcDist=()=>{
    const distToCm= parseInt(distance.value)*parseInt(multiplicator.value);

    //Convert to 1/1 scale
    const distToReal=distToCm*parseInt(scale1Dist.value);
    //Convert to final Scale
    const result=distToReal/parseInt(scale2Dist.value);
    document.getElementById('calc-result').textContent=result.toFixed(3);
}

convertBtn.addEventListener('click', ()=>{
    convert();
})

calcBtn.addEventListener('click',()=>{
    calcDist();
})