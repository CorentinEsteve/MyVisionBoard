body{height: 900px;
	background: #fff;
}
header {
	text-align: center;
	width: 100%;
	height: auto;
	background-size: cover;
	background-attachment: fixed;
	position: relative;
	overflow: hidden;
}
header .overlay{
	width: 100%;
	height: 100%;
	padding: 20%;			/* modifié, taille du header */	
	color: #FFF;
	text-shadow: 1px 1px 1px #333;
	background: -webkit-linear-gradient(90deg, #134E5E 10%, #71B280 90%); /* Chrome 10+, Saf5.1+ */
	background:    -moz-linear-gradient(90deg, #134E5E 10%, #71B280 90%); /* FF3.6+ */
	background:     -ms-linear-gradient(90deg, #134E5E 10%, #71B280 90%); /* IE10 */
	background:      -o-linear-gradient(90deg, #134E5E 10%, #71B280 90%); /* Opera 11.10+ */
	background:         linear-gradient(90deg, #134E5E 10%, #71B280 90%); /* W3C */	
}

h1 {
	font-family: 'Open Sans', cursive;
	font-size: 80px;
	margin-bottom: 30px;
}

h3, p {
	font-family: 'Open Sans', sans-serif;
	margin-bottom: 30px;
}

button {
	cursor: pointer;
	outline: 0;
	display: inline-block;
	font-weight: 400;
	line-height: 1.5;
	text-align: center;
	background-color: transparent;
	border: 1px solid transparent;
	padding: 6px 12px;
	font-size: 1rem;
	border-radius: .25rem;
	transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	color: #ffffff;
	border-color: #ffffff;
	margin-top:100px;
	width:30%;
	font-size: 20px;
	font-family: 'Oswald';
}


button:hover {
	color: #134E5E;
	background-color: #ffffff;
	border-color: none;
}


	  



/* import */




html {
	font: normal 112.5%/1.65 serif; /* base font size 18px with 1.65 line-height */
	-moz-font-feature-settings: "liga=1, dlig=1"; /* common and discretionary ligatures */
	-ms-font-feature-settings: "liga", "dlig";
	-webkit-font-feature-settings: "liga", "dlig";
	-o-font-feature-settings: "liga", "dlig";
	font-feature-settings: "liga", "dlig";
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
	line-height: 1;
	margin-top: 0;
	color: #fff;
	  display: inline-block;
	  position: relative;
  }
  p{
	margin-top: 4rem;
	color: #fff;
	font-size: 0.9rem;
	line-height: 1
  }
  .gigantic{font-size: 11rem;}
  .supersize{font-size: 8rem;}
  .tera {
	font-size: 6.5rem; /* 117 / 18 = 6.5 */
	margin-bottom: 0.25385rem;
  }
  
  .giga {
	font-size: 5rem; /* 90 / 18 = 5 */
	margin-bottom: 0.33rem;
  }
  
  .mega {
	font-size: 4rem; /* 72 / 18 = 4 */
	margin-bottom: 0.4125rem;
  }
  
  .alpha {
	font-size: 3.33333rem; /* 60 / 18 = 3.3333 */
	margin-bottom: 0.495rem;
  }
  
  .beta {
	font-size: 2.6667rem; /* 48 / 18 = 2.6667 */
	margin-bottom: 0.61875rem;
  }
  
  .gamma {
	font-size: 2rem; /* 36 / 18 = 2 */
	margin-bottom: 0.825rem;
  }
  
  .delta {
	font-size: 1.3333333333333333rem; /* 24 / 18 = 1.3333 */
	margin-bottom: 1.2375rem;
  }
  
  .epsilon {
	font-size: 1.16667rem; /* 21 / 18 = 1.1667 */
	margin-bottom: 1.41429rem;
  }
  
  .zeta {
	font-size: 1rem; /* 18 = 18 × 1 */
	margin-bottom: 1.65rem;
  }
  /* ==== Typefaces  ==== */
  
  .open-sans{font-family: 'Open Sans';}
  .lato{font-family: 'Lato'}
  .playfair-display{font-family: 'Playfair Display'}
  .libre-baskerville{font-family: 'Libre Baskerville'}
  .oswald{font-family: 'Oswald'}
  .montserrat{font-family: 'Montserrat'}
  .vollkorn{font-family: 'Vollkorn'}
  .bree-serif{font-family: 'Bree Serif'}
  .raleway{font-family: 'Raleway'}
  .merriweather{font-family: 'Merriweather'}
  .cardo{font-family: 'Cardo'}
  .abril-fatface{font-family: 'Abril Fatface'}
  .muli{font-family: 'Muli'}
  
  /* ==== Weights, styles, letterspacing, etc. ==== */
  
  .thin{font-weight: 100;}
  .light{font-weight: 300;}
  .regular{font-weight: 400;}
  .bold{font-weight: 700;}
  .italic{font-style: italic;}
  .normal{font-style: normal;}
  .ls-small{letter-spacing: 2px;}
  .ls-medium{letter-spacing: 4px;}
  .ls-large{letter-spacing: 8px;}
  .ls-xlarge{letter-spacing: 12px;}
  .uppercase{text-transform: uppercase;}
  .color-emphasis-1{color: #FF4056}
  .color-emphasis-2{color: #000;}
  .color-emphasis-3{color: #60547c}
  .text-left{text-align: left;}
  .line-height-small{line-height: 1.2}
  .line-height-medium{line-height: 1.45}
  .line-height-large{line-height: 1.65}
  
  
  /* ===== Flourish, heading horizontal lines, etc. ==== */
  
  .thick-header-line:before, .thick-header-line:after{
	  content: "";
	  display: block;
	  position: absolute;
	  width:7rem;
	  height: 4px;
	  background-color: #fff;
	  top:50%;
	  margin-bottom: -4px;
  }
  .thick-header-line:before{
	  left: -7.5rem;
  }
  .thick-header-line:after{
	  right: -7.5rem;
  }
  
  .thin-header-line:before, .thin-header-line:after{
	  content: "";
	  display: block;
	  position: absolute;
	  width:7rem;
	  height: 1px;
	  background-color: #fff;
	  top:50%;
	  margin-bottom: -1px;
  }
  .thin-header-line:before{
	  left: -7.5rem;
  }
  .thin-header-line:after{
	  right: -7rem;
  }
  .line-after-heading:before{
	  content: "";
	  display: block;
	  position: absolute;
	  background-color: #fff;
	  width:4rem;
	  height: 2px;
	  margin-left: auto;
	  margin-right: auto;
	  left: 0;
	  right: 0;
	  bottom: -2rem;
	  
  }
  .double-header-line:before, .double-header-line:after{
	  content: "";
	  display: block;
	  position: absolute;
	  width:7rem;
	  background-color: transparent;
	  height: 4px;
	  border-top: 1px solid #fff;
	  border-bottom:1px solid #fff;
	  top: 50%;
	  margin-bottom: -4px;
  }
  .double-header-line:before{
	  left: -7.5rem;
  }
  .double-header-line:after{
	  right: -7.5rem;
  }
  .decorative-span{
	display: inline-block;
	  font-size: 30px;
	  line-height: 60px;
	  margin: 0 10px;
	  position: relative;
	  vertical-align: middle;
	  color: #fff;
  }
  .decorative-span:before, .decorative-span:after{
	  background-color: #fff;
	  bottom: 100%;
	  content: "";
	  height: 2px;
	  left: 0;
	  position: absolute;
	  right: 0;
  }
  .decorative-span:after {
	  top: 96%;
  }
  
  .text-overlay:before{
	  content: attr(data-text);
	  z-index: 99;
	  width: 98%;
	  height: 50px;
	  background-color: hsla(0,0%,0%,0.6);
	  position: absolute;
	  margin-left: auto;
	  margin-right: auto;
	  left: 0;
	  right: 0;
	  top: 50%;
	  transform: translateY(-50%);
	  line-height: 50px;
	  text-align: center;
	  color:#f0ad00;
	  font-family: 'bree serif';
	  font-style: normal;
	  font-size: 1.3rem;
	  letter-spacing: 0;
	  text-transform: none;
	  font-weight: 400;
  }
  



















  * {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
  }
  
  body {
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
	  Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  }
  
  .main-container {
	padding: 30px;
  }
  
  /* HEADING */
  
  .heading {
	text-align: center;
  }
  
  .heading__title {
	font-weight: 600;
  }
  
  .heading__credits {
	margin: 10px 0px;
	color: #888888;
	font-size: 25px;
	transition: all 0.5s;
  }
  
  .heading__link {
	text-decoration: none;
  }
  
  .heading__credits .heading__link {
	color: inherit;
  }
  
  /* CARDS */
  
  .cards {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
  }
  
  .card {
	margin: 20px;
	padding: 20px;
	width: 500px;
	min-height: 200px;
	display: grid;
	grid-template-rows: 20px 50px 1fr 50px;
	border-radius: 10px;
	box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.25);
	transition: all 0.2s;
  }
  
  .card:hover {
	box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.4);
	transform: scale(1.01);
  }
  
  .card__link,
  .card__exit,
  .card__icon {
	position: relative;
	text-decoration: none;
	color: rgba(255, 255, 255, 0.9);
  }
  
  .card__link::after {
	position: absolute;
	top: 25px;
	left: 0;
	content: "";
	width: 0%;
	height: 3px;
	background-color: rgba(255, 255, 255, 0.6);
	transition: all 0.5s;
  }
  
  .card__link:hover::after {
	width: 100%;
  }
  
  .card__exit {
	grid-row: 1/2;
	justify-self: end;
  }
  
  .card__icon {
	grid-row: 2/3;
	font-size: 30px;
  }
  
  .card__title {
	grid-row: 3/4;
	font-weight: 400;
	color: #ffffff;
  }
  
  .card__apply {
	grid-row: 4/5;
	align-self: center;
  }
  
  /* CARD BACKGROUNDS */
  
  .card-1 {
	background: radial-gradient(#1fe4f5, #3fbafe);
  }
  
  .card-2 {
	background: radial-gradient(#fbc1cc, #fa99b2);
  }
  
  .card-3 {
	background: radial-gradient(#76b2fe, #b69efe);
  }
  
  .card-4 {
	background: radial-gradient(#60efbc, #58d5c9);
  }
  
  .card-5 {
	background: radial-gradient(#f588d8, #c0a3e5);
  }
  
  /* RESPONSIVE */
  
  @media (max-width: 1600px) {
	.cards {
	  justify-content: center;
	}
  }
  
  