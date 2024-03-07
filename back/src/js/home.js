document.querySelector('#addProduct').addEventListener("click", function(){
    const product = document.querySelector('#select-product').value;
    const amount = document.querySelector('#amount').value;
    if(product === ''){
        alert('Por favor, selecione um produto.');
    }
    else if(amount <= 0 || amount === ''){
        alert('Arrume a quantidade de produtos.')
    }
    else{
    }
})