const zoomContainer=document.getElementById('zoom-container');
const closeZoomBtn=document.getElementById('close-zoom');
const pictureDivs=document.querySelectorAll('.image-container');
const zoomPicture=document.getElementById('zoom-picture');
const parentContainer=document.querySelector('.main-kit-container');

closeZoomBtn.addEventListener('click',()=>{
    parentContainer.classList.remove('blured');
    zoomContainer.classList.add('hidden');
})

pictureDivs.forEach((div)=>{
    const filename=div.dataset.file;
    div.addEventListener('click',()=>{
        zoomPicture.src=filename;
        parentContainer.classList.add('blured');
        zoomContainer.classList.remove('hidden');
    })
})