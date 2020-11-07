var wooYayIntervalId = 0;

function wooYayClickHandler ( )
{
  if ( document.getElementById("wooYayButton").value == "Click me!" )
  {
    // Start the timer
    document.getElementById("wooYayButton").value = "Enough already!";
    wooYayIntervalId = setInterval ( "wooYay()", 1000 );
  }
  else
  {
    document.getElementById("wooYayMessage").innerHTML = "";
    document.getElementById("wooYayButton").value = "Click me!";
    clearInterval ( wooYayIntervalId );
  }
}

function wooYay ( )
{
  if ( Math.random ( ) > .5 )
  {
    document.getElementById("wooYayMessage").innerHTML = "Woo!";
  }
  else
  {
    document.getElementById("wooYayMessage").innerHTML = "Yay!";
  }

  setTimeout ( 'document.getElementById("wooYayMessage").innerHTML = ""', 500 );

}

