const modelsCards = document.querySelectorAll('.draggable');
const dropZones = document.querySelectorAll('.dropzone');
const dropAllow = ['liked-kits', 'ordered', 'stock', 'wip', 'finished'];

const toastDetails = {
    timer: 5000,
    success: {
        icon: "fa-circle-check",
        classname: "toast_success"
    },
    error: {
        icon: "fa-circle-xmark",
        classname: "toast_error"
    }
}

function allowDrop(e) {
    e.preventDefault();
    const idReceive = e.target.id;
    if (!dropAllow.includes(idReceive)) {
        return;
    }
    e.target.classList.add('dropOK');
}


modelsCards.forEach((card) => {
    card.addEventListener('dragstart', (e) => {
        drag(e);
    });
});

dropZones.forEach((dropzone) => {
    dropzone.addEventListener('dragover', (e) => {
        allowDrop(e);
    });
    dropzone.addEventListener('drop', (e) => {
        drop(e);
    })
    dropzone.addEventListener('dragleave', (e) => {
        dragLeave(e);
    });
})

function drag(e) {
    e.dataTransfer.setData('text', e.target.id);
}


const dragLeave = (e) => {
    if (e.target.classList.contains('dropOK')) {
        e.target.classList.remove('dropOK');
    }
}

async function drop(e) {
    e.preventDefault();
    const idReceive = e.target.id;
    const newState = e.target.dataset.id;
    if (!dropAllow.includes(idReceive)) {
        return;
    }
    let data = e.dataTransfer.getData("text");
    const card = document.getElementById(data);
    const idCard = card.dataset.id;
    const result = await sendUpdateState(idCard, newState);
    e.target.classList.remove('dropOK');
    if (result) {
        try {
            e.target.appendChild(card);
        }
        catch (e) { }
    }
    else {
        launchFlash(toastDetails.error, 'Une erreur est survenue');
    }
}

const sendUpdateState = async (id, state) => {
    let test = false;
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ idModel: id, newState: state })
    };

    await fetch('api_updateState', myInit)
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
            if (json.result) {
                //Ok, tout c'est bien passé
                test=true;
            }
            else {
                //Erreur
                test= false;
            }
        });
        return test;
}

const launchFlash = (typeFlash, message) => {
    if (document.getElementsByClassName('toast_notifications').length === 0) {
        const flashContainer = document.createElement('ul');
        flashContainer.classList.add('toast_notifications');
        document.body.appendChild(flashContainer);
    }
    flashContainer = document.getElementsByClassName('toast_notifications')[0];
    const toast = document.createElement('li');
    toast.className = typeFlash.classname;
    toast.classList.add('toast');
    const divToast = document.createElement('div');
    divToast.className = "toast_column";
    const icon = document.createElement('i');
    icon.classList.add('fa-solid');
    icon.classList.add(typeFlash.icon);
    const spanMessage = document.createElement('span');
    spanMessage.innerText = message;
    divToast.appendChild(icon);
    divToast.appendChild(spanMessage);
    const closeIcon = document.createElement('i');
    closeIcon.classList.add('fa-solid');
    closeIcon.classList.add('fa-xmark');
    closeIcon.addEventListener('click', () => removeToast(toast));
    toast.appendChild(divToast);
    toast.appendChild(closeIcon);
    flashContainer.appendChild(toast);
    toast.timeouId = setTimeout(() => removeToast(toast), toastDetails.timer);
}
