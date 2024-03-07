document.querySelector('#addCategory').addEventListener('click', function(){
    const category = document.querySelector('#category-name').value;
    const tax = document.querySelector('#tax-value').value;
    const regexText = /^[A-Za-z0-9_]+$/g;
    
    if(category === '' || regexText.test(category) === false){
        alert('Insira um nome pra categoria.');
    }
    else if(tax <= 0 || tax === ''){
        alert('Insira uma taxa maior que 0%.');
    }
    else {
    }
})