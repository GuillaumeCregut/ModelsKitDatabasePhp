const scale1 = document.getElementById('scale1');
const scale2 = document.getElementById('scale2');
const convertBtn = document.getElementById('btn-convert');
const distance = document.getElementById('distance');
const multiplicator = document.getElementById('multiplicator');
const scale1Dist = document.getElementById('scale1-dist');
const scale2Dist = document.getElementById('scale2-dist');
const calcBtn = document.getElementById('btn-calc');

const convert = () => {
    const s1 = parseInt(scale1.value);
    const s2 = parseInt(scale2.value);
    const result = (s1 / s2) * 100;
    document.getElementById('result').textContent = result.toFixed(0);
}

const calcDist = () => {
    let unity = 'mm';
    let divider = parseInt(multiplicator.value);
    switch (divider) {
        case 1: break;
        case 10: unity = 'cm'; 
            break;
        case 100: unity = 'm';
            break;
    }
    const distToMm = parseFloat(distance.value) * divider;

    //Convert to 1/1 scale
    const distToReal = distToMm * parseFloat(scale1Dist.value);
    //Convert to final Scale
    const result = distToReal / parseFloat(scale2Dist.value)/divider;
    document.getElementById('calc-result').textContent = `${result.toFixed(3)} ${unity}`;
}

convertBtn.addEventListener('click', () => {
    convert();
})

calcBtn.addEventListener('click', () => {
    calcDist();
})