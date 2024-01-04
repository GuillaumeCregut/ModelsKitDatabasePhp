const flipperCards=document.querySelectorAll('.card-flip'); //Replace with all
const likeButtons=document.querySelectorAll('.like-card-btn');
const addCartButtons=document.querySelectorAll('.cart-add-card');
const removeButtons=document.querySelectorAll('.delete-card');
const updateButtons=document.querySelectorAll('.update-card');
const token=document.getElementById('token').value;
console.log(token)
//Redirect to update page
const updateCart=(id)=>{
    location.href = `/parametres_modelUpdate?model=${id}`;
}


//Send to Api like info
const sendLike=(id,value,btn, btnState)=>{
    const heart=btn.querySelector('.model-like');
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idModel:id, newLike:value,token:token})
      };
    
    fetch('api_likemodel',myInit)
    .then((response)=>{
        if(response.ok){
            return response.json()
        }
        else{
            //Une erreur réseau c'esdt produite (voir pour l'afficher)
            return response;
        }
    })
    .then((json)=>{
        if(json.result){
           //Ok, tout c'est bien passé
           heart.classList.toggle('model-like-true');
           btn.dataset.like=btnState;
        }
        else{
           //Erreur
           launchFlash(toastDetails.error,'Une erreur est survenue');
        }
    });
}

//Send to Api cart info
const sendCart=(id)=>{
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idModel:id,token:token})
      };
      fetch('api_addCart',myInit)
      .then((response)=>{
          if(response.ok){
              return response.json()
          }
          else{
              //Une erreur réseau c'esdt produite (voir pour l'afficher)
              return response;
          }
      })
      .then((json)=>{
        if(json.result){
           //Ok, tout c'est bien passé
          launchFlash(toastDetails.success,'Le kit a bien été rajouté à votre stock')
        }
        else{
           //Erreur
           launchFlash(toastDetails.error,'Une erreur est survenue');
        }
    });
};

//Send deleteCard
const sendDelete=(id, name)=>{
    if(confirm(`Voulez-vous supprimer ${name} ?`)){
        const formDelete=document.getElementById('form-delete-model');
        const hiddenId=document.getElementById('id_hidden');
        hiddenId.value=id;
        formDelete.submit();
    }
}

//Flip card
flipperCards.forEach((flipperCard)=>{
    flipperCard.addEventListener('click',()=>{
        const innerCard=flipperCard.children[0];
        innerCard.classList.toggle('turned');
    });
});

//Like Button
likeButtons.forEach((likeBtn)=>{
    likeBtn.addEventListener('click',()=>{
        const id=likeBtn.dataset.id;
        let oldLike=likeBtn.dataset.like;
        if(oldLike!=='1'){
            oldLike='false';
        }
        else{
            oldLike='true';
        }
        let like=false;
        let likeBtnState="false";
        if(oldLike==='false'){
            like=true;
            likeBtnState='1';
        }
        sendLike(id,like,likeBtn, likeBtnState);
    });
});


//Cart buttons
addCartButtons.forEach((cartBtn)=>{
    cartBtn.addEventListener('click',()=>{
        const id=cartBtn.dataset.id;
        sendCart(id);
    });
});


//RemoveCard
removeButtons.forEach((removeBtn)=>{
    removeBtn.addEventListener('click',()=>{
        const id=removeBtn.dataset.id;
        const name=removeBtn.dataset.name;
        sendDelete(id,name);
    });
});


//Update buttons
updateButtons.forEach((updateBtn)=>{
    updateBtn.addEventListener('click',()=>{
        const id=updateBtn.dataset.id;
        updateCart(id);
    });
});

