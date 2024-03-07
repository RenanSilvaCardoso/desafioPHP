document.querySelector('#addProduct').addEventListener("click", function(){
    const product = document.querySelector('#product-name').value;
    const amount = document.querySelector('#amount').value;
    const price = document.querySelector('#unit-price').value;
    const category = document.querySelector('#select-category').value;

    const regexText = /^[A-Za-z0-9_]+$/g;

    if(product === '' || regexText.test(product) === false){
        alert('Insira o nome do produto');
    }
    else if(amount <= 0 || amount === ''){
        alert('A quantidade não pode ser negativa ou nula.');
    }
    else if(price <= 0 || price === '' ){
        alert('O preço não pode ser negativo ou nulo.');
    }
    else if(category === '' ){
        alert('Selecione uma categoria');
    }
    else{
    }
})