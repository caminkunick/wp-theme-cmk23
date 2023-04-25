const fs = require("fs");
const package = require("./package.json");

//SECTION - sass/style.scss
const style = fs.readFileSync("./sass/style.scss", "utf-8");
const style_match = style.match(/Version: ([.0-9]+)/);

if (style_match && style_match[1] !== package.version) {
  fs.writeFileSync(
    "./sass/style.scss",
    style.replace(style_match[1], package.version)
  );
  console.log("sass/style.scss updated.");
}
//!SECTION

//SECTION - functions.php
const functions = fs.readFileSync("./functions.php", "utf-8");
const functions_match = functions.match(/'_S_VERSION', '([.0-9]+)'/);

if(functions_match && functions_match[1] !== package.version){
  fs.writeFileSync(
    "./functions.php",
    functions.replace(functions_match[1], package.version)
  );
  console.log("functions.php updated.");
}
//!SECTION

//SECTION - theme.json
const theme = fs.readFileSync("./theme.json", "utf-8");
const theme_match = theme.match(/"version": "([.0-9]+)",/);

if(theme_match && theme_match[1] !== package.version){
  var re = new RegExp(theme_match[1], 'g');
  fs.writeFileSync(
    "./theme.json",
    theme.replace(re, package.version)
  );
  console.log("theme.json updated.");
}
//!SECTION

// Stable tag: 1.0.1

console.log("Done.");