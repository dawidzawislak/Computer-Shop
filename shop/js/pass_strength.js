function check(input) {
  let pass = input.value;
  let ind1 = $('#indicator1');
  let ind2 = $('#indicator2');
  let strength = $('#strength');
  let points = 0;
  console.log(pass);
  if(pass.length == 0) {
    ind1.hide();
    strength.text("");
  } else {
    ind1.show();
    strength.text("Słabe hasło");
    
    if(pass.length >= 8) points++;
    if(pass.length > 11) points++;
    if(pass.length > 14) points++;
    if(pass.length > 17) points++;
    if(pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) points++;
    if(pass.match(/.[0-9]/) && pass.match(/.[A-Za-z]/)) points++;

    let color = "#ff3333";
    console.log();
    let width = points/6.0 * 100;
    ind2.css("width", width+"%");
    if(points >= 2)
    {
      strength.text("Średnie hasło");
      color = "#ff9933";
    }
    if(points >= 4)
    {
      strength.text("Silne hasło");
      color = "#339933";
    }
    ind2.css("background-color", color);
  };
};