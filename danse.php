<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="back.css">
        <link rel="stylesheet" href="./fontawesome/css/all.css">

    <title>Document</title>
</head>
<style>
    *{
 font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    
}
section{
    width: 100%;
    height: 110vh;
    background: linear-gradient(to right,#000000, #1b1364,#2a28c4);
    padding: 2vw;

}
section .d1{
    width: 20vw;
    height: 2vw;
    display: flex;
    gap: -1vw;
    margin-left: 4vw;
}
section .d1 i{
    font-size: 2.5vw;
    color: white;
    animation: animb 12s linear infinite;
}
@keyframes animb{
    0%{}
    50%{
        transform:rotateY(360deg);
    }
    100%{}
}
section hr{
    align-items: center;
    margin-left: 25vw;
    width: 47%;
    margin-top: 1vw;
    border-color: blueviolet;
    animation: animhr 5s linear infinite;
}
@keyframes animhr{
    0%{}
    50%{
        border-color: rgb(55, 232, 238);
        transform:scaleX(2);
    }
    100%{}

}
section h1{
    margin-left: 1vw;
    font-size: 1vw;
    margin-top: 0.5vw;
    
}
section div div h2{
    font-size: 4vw;
    margin: 5vw;
    font-family: cursive;

}
section div div p{
    font-size:3vw;
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
}
section div div button{
    width: 20vw;
    height: 4vw;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 3vw;
    border-radius: 2vw;
    background: linear-gradient(rgb(92, 2, 92),blueviolet);
    border: none;
    color: rgba(0, 0, 0, 0.74);
    text-transform: capitalize;
    margin-top: 5vw;
    cursor: pointer;
}
section button:hover {
    background: rgb(87, 189, 223);
    transition: 0.2s;
    border-radius: 0.5vw;
    color: rgba(0, 0, 0, 0.76);
}
section div{
    width: 100%;
    display: flex;
}
section div div{
    padding-top: 1vw;
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
section div div img{
    width: 180%;
    height: 20vw;
    margin-bottom: 2vw;
}
section div div .p1{
    position: absolute;
    color: black;
    font-size: 3vw;
    font-weight: bolder;
    top: 8vw;
    right: 6vw;
}

section div div .p2{
    position: absolute;
    color: black;
    font-size: 3vw;
    font-weight: bolder;
    bottom: 1vw;
    right: 22vw;
}


</style>
<body>
    <section>
        <div class="d1">
            <i class="fa fa-globe"></i>
            <h1>ESMIA UNIVERSITY</h1>
        </div>
        <hr>
        <div>
            <div>
                <h2>Envie de Danser?</h2>
                <p>Rejoignez notre club et vivez <br> votre passion en bougeant <br> avec nous.</p>
                <a href=""><button>s'inscrire</button></a>
            </div>
        <div>
            <div>
                <p class="p1">Danse urbaine</p>
                <img src="./images.jpeg" alt="" class="">
            </div>
            <div>
                <p class="p2">Zumba</p>
                <img src="./i107016-zumba.webp" alt="">
            </div>
        </div>
    </div>
    </section>
</body>
</html>