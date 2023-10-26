const flipperCards=document.querySelectorAll('.card-flip'); //Replace with all


//Flip card
flipperCards.forEach((flipperCard)=>{
    flipperCard.addEventListener('click',()=>{
        const innerCard=flipperCard.children[0];
        innerCard.classList.toggle('turned');
    });
});
