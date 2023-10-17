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
const toastDetails={
    timer: 5000,
    success:{
        icon: "fa-circle-check",
        classname: "toast_success"
    },
    error:{
        icon: "fa-circle-xmark",
        classname:"toast_error"
    }
}

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
        launchFlash(toastDetails.error,'Vous êtes limité à 4 fichiers')
        return;
    }
    const localFiles=fileField.files;
    //Traiter si il y a plusieurs fichiers...
    for (let i = 0; i < localFiles.length; i++) {
        const newFile=localFiles[i];
        if((newFile.type==='image/jpeg' || newFile.type==="image/png") && newFile.size<DEFAULT_MAX_FILE_SIZE_IN_BYTES){
            if(filesArray.length<MaxFileCount){
                filesArray.push(localFiles[i]);
                createCard(localFiles[i]);
                uploadBtn.classList.remove('hidden-btn');
            }
            else{
                launchFlash(toastDetails.error,'Vous êtes limité à 4 fichiers')
            }
        }
        else{
            //Laucnch flash
            launchFlash(toastDetails.error,"veuillez n'envoyer que des images png et jpg, 500ko max")
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
    card.classList.add('preview-element');
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

cleanUploadZone=()=>{
    const previews=previewContainer.querySelectorAll('.preview-element');
    previews.forEach((preview)=>{
        previewContainer.removeChild(preview);
    })
}

const createPicturCard=(filename)=>{
    const pictureBox=document.querySelector('.picturebox');
    if(document.getElementById('no-photo')!==null){
        const pNoPhoto=document.getElementById('no-photo');
        pictureBox.removeChild(pNoPhoto);
    }
    const pictureContainer=document.querySelector('.picture-container');
    pictureContainer.classList.remove('hidden');
    const imageCard=document.createElement('li');
    const firstDiv=document.createElement('div');
    const secondDiv=document.createElement('div');
    secondDiv.className='image-container';
    secondDiv.dataset.file=filename;
    const pictureDisplay=document.createElement('img');
    pictureDisplay.src=filename;
    pictureDisplay.classList.add('img-model');
    secondDiv.appendChild(pictureDisplay);
    firstDiv.appendChild(secondDiv);
    imageCard.appendChild(firstDiv);
    const deletePictureBtn=document.createElement('button');
    deletePictureBtn.classList.add('btn-delete-picture');
    deletePictureBtn.dataset.file=filename;
    const svg=document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('stroke',"currentColor");
    svg.setAttribute('fill',"currentColor");
    svg.setAttribute('stroke-width' ,"0");
    svg.setAttribute('viewBox',"0 0 448 512");
    svg.setAttribute('height',"1em");
    svg.setAttribute('width',"1em");
    svg.classList.add('trash-delete-icon');
    svg.innerHTML='<path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path>';
    deletePictureBtn.appendChild(svg);
    deletePictureBtn.addEventListener('click',()=>{
        deleteFile(filename);
    })
    imageCard.appendChild(deletePictureBtn);
    pictureContainer.appendChild(imageCard);
}

//Send to backend
uploadBtn.addEventListener('click',()=>{
    const formData=new FormData();
    filesArray.forEach((theFile,index)=>{
        formData.append(index,theFile);
    });
    const idModel=document.getElementById('id_add').value;
    formData.append('id',idModel);
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
                return response;
            }
        })
        .then((json) => {
            if(json.files!==undefined){
                const files=json.files;
                if(files.length>0){
                    //display cards
                    files.forEach((filename)=>{
                        createPicturCard(filename);
                    })
                    cleanUploadZone();
                }
            }
            else{
                launchFlash(toastDetails.error,"Une erreur s'est produite");
            }
        })
});

const launchFlash=(typeFlash,message)=>{
    if(document.getElementsByClassName('toast_notifications').length===0)
    {
        const flashContainer=document.createElement('ul');
        flashContainer.classList.add('toast_notifications');
        document.body.appendChild(flashContainer);
    }
    flashContainer=document.getElementsByClassName('toast_notifications')[0];
    const toast=document.createElement('li');
    toast.className=typeFlash.classname;
    toast.classList.add('toast');
    const divToast=document.createElement('div');
    divToast.className="toast_column";
    const icon=document.createElement('i');
    icon.classList.add('fa-solid');
    icon.classList.add(typeFlash.icon);
    const spanMessage=document.createElement('span');
    spanMessage.innerText=message;
    divToast.appendChild(icon);
    divToast.appendChild(spanMessage);
    const closeIcon=document.createElement('i');
    closeIcon.classList.add('fa-solid');
    closeIcon.classList.add('fa-xmark');
    closeIcon.addEventListener('click',()=>removeToast(toast));
    toast.appendChild(divToast);
    toast.appendChild(closeIcon);
    flashContainer.appendChild(toast);
    toast.timeouId=setTimeout(()=>removeToast(toast),toastDetails.timer);
}