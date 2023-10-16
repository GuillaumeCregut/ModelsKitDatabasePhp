const zoomContainer=document.getElementById('zoom-container');
const closeZoomBtn=document.getElementById('close-zoom');
const pictureDivs=document.querySelectorAll('.image-container');
const zoomPicture=document.getElementById('zoom-picture');
const parentContainer=document.querySelector('.main-kit-container');
const deletePictureBtns=document.querySelectorAll('.btn-delete-picture');

closeZoomBtn.addEventListener('click',()=>{
    parentContainer.classList.remove('blured');
    zoomContainer.classList.add('hidden');
});

const deleteFile=(filename)=>{
    if(window.confirm('Voulez-vous supprimer cette image ?')){
        const inputFilename=document.getElementById('filename-delete');
        const formDeletePicture=document.getElementById('delete-picture-form');
        inputFilename.value=filename;
        formDeletePicture.submit();
    }
}

pictureDivs.forEach((div)=>{
    const filename=div.dataset.file;
    div.addEventListener('click',()=>{
        zoomPicture.src=filename;
        parentContainer.classList.add('blured');
        zoomContainer.classList.remove('hidden');
    })
})

deletePictureBtns.forEach((btn)=>{
    const filename=btn.dataset.file;
    btn.addEventListener('click',()=>{
        deleteFile(filename);
    })
})