<?php

if(!isset($_COOKIE['user_id'])){
    header('Location: /get_registration.php');
}
?>

<div class="grid">
  <div class="item-1">
    <span>Lighting</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="alt">
    <span>Art & Decor</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="item-1">
    <span>Storage</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="item-1">
    <span>Flooring</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="item-1">
    <span>Bedding</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="alt">
    <span>Furniture</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="alt">
    <span>Entertainment</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="">
    <span>Accessories</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="alt">
    <span>Finishes</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
  <div class="item-1 alt">
    <span>Rugs</span>
    <span class="shop"></span>
    <div class="overlay"></div>
  </div>
</div>

<style>
    {
        box-sizing: border-box;
    }

    :root {
        --gap: 8px;
    }

    body {
        margin: 0;
        font-family: system-ui;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--gap);
        padding: var(--gap);
        height: 100vh;
        position: relative;
        background: hsl(220, 35%, 5%);
    //Prefixes
    display: -ms-grid;
        -ms-grid-columns: (1fr)[4];

        & div {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-end;
            padding: calc(var(--gap) * 1.5);
            min-height: 160px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            background-color: teal;
            background-image: url('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?crop=entropy&cs=srgb&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MDA0NjcyNw&ixlib=rb-1.2.1&q=85');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            transition-property: filter, backdrop-filter, opacity, color;
            transition-duration: .3s;
            transition-timing-function: ease-out;
        //Prefixes
        display: -webkit-box;
            display: -ms-flexbox;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            -webkit-box-align: start;
            -ms-flex-align: start;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            -webkit-transition-property: opacity, color, -webkit-filter, -webkit-backdrop-filter;
            transition-property: opacity, color, -webkit-filter, -webkit-backdrop-filter;
            -webkit-transition-duration: .3s;
            -webkit-transition-timing-function: ease-out;

            &:hover {
                color: #fff;
            }

            & span:first-of-type {
                z-index: 2;
            }

            & .overlay {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                background: linear-gradient(180deg, hsl(0, 0%, 0%, 0) 5%, hsl(0, 0%, 0%, .8));
                backdrop-filter: blur(6px);
                transition-property: opacity;
                transition-duration: .4s;
                transition-timing-function: ease-out;
                z-index: -1;
            //Prefixes
            background: -webkit-linear-gradient(top, hsl(0, 0%, 0%, 0) 5%, hsl(0, 0%, 0%, .8));
                -webkit-backdrop-filter: blur(6px);
                -webkit-transition-property: opacity;
                -webkit-transition-duration: .4s;
                -webkit-transition-timing-function: ease-out;
            }

            & .shop {
                display: block;
                color: tomato;
                font-size: .8rem;
                font-weight: 400;
                margin-top: 8px;
                margin-bottom: -25px;
                opacity: 0;
                transition-property: margin-bottom, opacity;
                transition-duration: .3s;
                <!--transition-timing-function: ethiopic-halehame-om-et;-->
                z-index: 2;
            //Prefixes
            -webkit-transition-property: margin-bottom, opacity;
                -webkit-transition-duration: .3s;
                <!---webkit-transition-timing-function: ethiopic-halehame-om-et;-->
            }

            &:hover > .overlay {
                opacity: 1;
            }

            &:hover {
                filter: brightness(1.2);
                -webkit-filter: brightness(1.2);
            }

            &:hover > .shop {
                opacity: 1;
                margin-bottom: 0;
            }

            &.alt {
            //background-image: url('https://images.unsplash.com/photo-1639682916310-3f383bc67cc4?crop=entropy&cs=srgb&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MDAzMTc0Mw&ixlib=rb-1.2.1&q=85');
            }
        }

        & > div:nth-of-type(1) {
            grid-column: 1/3;
        }

        & > div:nth-of-type(2) {
            grid-column: 3/5;
            grid-row: 1/3;
        }

        & > div:nth-of-type(4) {
            grid-column: 2/3;
            grid-row: 2/5;
        }
    }

    @media screen and (max-width: 840px) {
        .grid {
            height: auto;
            grid-template-columns: repeat(2, 1fr);

            & div {
                min-height: auto;
                aspect-ratio: 1 / 1;
                width: 100%;
            }

            & > div:nth-of-type(1) {
                grid-column: auto;
            }

            & > div:nth-of-type(2) {
                grid-column: auto;
                grid-row: auto;
            }

            & > div:nth-of-type(4) {
                grid-column: auto;
                grid-row: auto;
            }
        }
    }
</style>