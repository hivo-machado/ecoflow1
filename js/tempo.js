var nrImagem = 0;
        var imagens = [];
        var refrescar = 1; // mudar imagem de 1 em 1 segundo
        
        imagens[0] = "img/vendas1.png";
        imagens[1] = "img/vendas2.png";
        imagens[2] = "img/vendas3.png";
        
        rodarImagens = function () {
           document.images["misto"].src = imagens[nrImagem];

           nrImagem = (nrImagem + 1) % imagens.length; 
        }
        var intervalControl = setInterval(rodarImagens, 5000 * refrescar);