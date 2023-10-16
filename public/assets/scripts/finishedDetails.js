const zoomContainer=document.getElementById('zoom-container');
const closeZoomBtn=document.getElementById('close-zoom');
const pictureDivs=document.querySelectorAll('.image-container');
const zoomPicture=document.getElementById('zoom-picture');
const parentContainer=document.querySelector('.main-kit-container');
const deletePictureBtns=document.querySelectorAll('.btn-delete-picture');
const upLoadFileBtn=document.querySelector('.upload-file-btn');
const fileField=document.getElementById('files-field');
const previewContainer=document.querySelector('.preview-list');
const nbFiles=document.getElementById('count-files').value;
const uploadBtn=document.getElementById('UpLoadBtn');

const MaxFileCount=4-nbFiles;
let countFiles=0;
let filesArray=[];
const DEFAULT_MAX_FILE_SIZE_IN_BYTES = 500000;
const KILO_BYTES_PER_BYTE = 1000;

//Zoom 
closeZoomBtn.addEventListener('click',()=>{
    parentContainer.classList.remove('blured');
    zoomContainer.classList.add('hidden');
});

pictureDivs.forEach((div)=>{
    const filename=div.dataset.file;
    div.addEventListener('click',()=>{
        zoomPicture.src=filename;
        parentContainer.classList.add('blured');
        zoomContainer.classList.remove('hidden');
    })
});

//Delete file
const deleteFile=(filename)=>{
    if(window.confirm('Voulez-vous supprimer cette image ?')){
        const inputFilename=document.getElementById('filename-delete');
        const formDeletePicture=document.getElementById('delete-picture-form');
        inputFilename.value=filename;
        formDeletePicture.submit();
    }
};

deletePictureBtns.forEach((btn)=>{
    const filename=btn.dataset.file;
    btn.addEventListener('click',()=>{
        deleteFile(filename);
    })
});

//Add new File
upLoadFileBtn.addEventListener('click',(e)=>{
    e.preventDefault();
    fileField.click();
});

//On add new file
fileField.addEventListener('change',(e)=>{
    if(filesArray.length>MaxFileCount){
        //Send a flash message
        console.log('MAx autorisé');
        return;
    }
    const localFiles=fileField.files;
    //Traiter si il y a plusieurs fichiers...
    for (let i = 0; i < localFiles.length; i++) {
        const newFile=localFiles[i];
        if(newFile.type==='image/peg' || newFile.type==="image/png" || newFile.size<DEFAULT_MAX_FILE_SIZE_IN_BYTES){
            if(filesArray.length<MaxFileCount){
                filesArray.push(localFiles[i]);
                createCard(localFiles[i]);
                uploadBtn.classList.remove('hidden-btn');
            }
            else{
                console.log('Compte maximum atteint')
            }
        }
        else{
            //Laucnch flash
            console.log('Ne rempli pas les critères');
        }
    };
})

const deleteFileFromArray=(filename,id)=>{
    const tempArray=filesArray.filter((file)=>{
        if(file.name!=filename)
            return file;
    })
    filesArray=[...tempArray];
    const card=document.getElementById(id);
    previewContainer.removeChild(card);
    if(filesArray.length===0){
        uploadBtn.classList.add('hidden-btn');
    }
}

const convertBytesToKB = (bytes) => Math.round(bytes / KILO_BYTES_PER_BYTE);

const createCard=(file)=>{
    const rand=Math.round(Math.random()*100000+Math.random()*1000+Math.random()*100);
    const id=`card-${rand}`;
    const link=URL.createObjectURL(file);
    const card=document.createElement('article');
    card.id=id;
    const img=document.createElement('img');
    img.src=link;
    img.className='image-preview';
    card.appendChild(img);
    const fileData=document.createElement('div');
    fileData.className='file-meta-data-image';
    const spanName=document.createElement('span');
    spanName.textContent=file.name;
    fileData.appendChild(spanName);
    const aside=document.createElement('aside');
    const spanSize=document.createElement('span');
    spanSize.textContent=`${convertBytesToKB(file.size)} Kb`;
    aside.appendChild(spanSize);
    const deleteBtn=document.createElement('button');
    /*
<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" class="trash-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
    */
   deleteBtn.className='deleteBtnUpload';
   deleteBtn.addEventListener('click',()=>{
    deleteFileFromArray(file.name,id);
   });
   const svg=document.createElementNS('http://www.w3.org/2000/svg', 'svg');
   svg.classList.add("trash-icon");
   svg.setAttribute('stroke',"currentColor");
   svg.setAttribute('fill',"currentColor");
   svg.setAttribute('stroke-width' ,"0");
   svg.setAttribute('viewBox',"0 0 448 512");
   svg.setAttribute('height',"1em");
   svg.setAttribute('width',"1em");
   svg.innerHTML='<path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path>';
   deleteBtn.appendChild(svg);
   aside.appendChild(deleteBtn);
   fileData.appendChild(aside);
   card.appendChild(fileData);
   previewContainer.appendChild(card);
}

//Send to backend

uploadBtn.addEventListener('click',()=>{
    const formData=new FormData();
    console.log(filesArray);
    filesArray.forEach((theFile)=>{
        formData.append('file[]',theFile);
    })
    formData.append('id',12);
    const myInit = {
        method: "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: formData
    };

    fetch('api_addPictures', myInit)
        .then((response) => {
            if (response.ok) {
                return response.json()
            }
            else {
                test=false;
                //Une erreur réseau c'esdt produite (voir pour l'afficher)
                return response;
            }
        })
        .then((json) => {
            console.log(json);
        })
});
