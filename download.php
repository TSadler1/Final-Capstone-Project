<?php
if(isset($_GET['psentence'])){
//echo $_GET['psentence'];




echo "<script type=\"text/javascript\"> 
var buttons = [];
</script>";
if(isset($_GET['acrostic'])){
echo '<script type="text/javascript"> 
	buttons.push(4);
</script>';
}
if(isset($_GET['double'])){
echo '<script type="text/javascript"> 
	buttons.push(2);
</script>';
}
if(isset($_GET['quote'])){
echo '<script type="text/javascript"> 
	buttons.push(1);
</script>';

}
if(isset($_GET['word'])){
echo '<script type="text/javascript"> 
	buttons.push(3);
</script>';

}
if(isset($_GET['conjunction'])){
echo '<script type="text/javascript"> 
	buttons.push(0);
</script>';

}


$link = mysqli_connect("localhost", "root", "", "dictionary");
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
$sql2 = "SELECT * FROM quotes";
$listofQuotes = "";
if($result2 = mysqli_query($link, $sql2)){
    if(mysqli_num_rows($result2) > 0){
        while($row = mysqli_fetch_array($result2)){
	if($listofQuotes == ""){     $listofQuotes =  "" . $row['quote'] ;

}
else{
         $listofQuotes =   $listofQuotes . "," . $row['quote'] ;}
        }
 
$sql3 = "SELECT * FROM conjunctions";
$listofConjunctions = "";
if($result3 = mysqli_query($link, $sql3)){
    if(mysqli_num_rows($result3) > 0){
        while($row = mysqli_fetch_array($result3)){
	if($listofConjunctions == ""){     $listofConjunctions =  "" . $row['conjunction'] ;

}
else{
         $listofConjunctions =   $listofConjunctions . "," . $row['conjunction'] ;}
        }


echo "<script> var cookie10 = \"" . $listofConjunctions . "\"; </script>";

echo "<script> var cookie3 = \"" . $listofQuotes . "\"; </script>";

$sql = "SELECT * FROM words";
$listofWords = "";
$listofHints = "";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
if($listofWords == ""){     $listofWords =  "" . $row['word'] ;
				$listofHints = "" . $row['hint'] ;

}else{
	$listofHints = $listofHints. "#" . $row['hint'] ;

         $listofWords =   $listofWords . " " . $row['word'] ;}
        }

	echo "<script> var cookie = \"" . $listofWords . "\"; </script>";

	echo "<script> var cookie7 = \"" . $listofHints . "\"; </script>";

echo "<script> var cookie2 = \"" . $_GET['psentence'] . "\"; </script>";


echo "
<!DOCTYPE html>
<html>
<body>

<p id=\"puzzles\"></p>
<p id=\"solution\"></p>


<script type=\"text/javascript\"> 
var sentence =cookie2;
</script>";

echo "
<script type=\"text/javascript\">
var error = 0;
var endSolutionEND = \"\";
var endPuzzlesEND = \"\";

function wordSearch(wordGiven){

var hiddenWord = wordGiven.toUpperCase();
var cookies = cookie.toUpperCase();
const values = cookies.split(\" \");
";


echo '
var grid = new Array(hiddenWord.length+3);

for (var i = 0; i < grid.length; i++) {
  grid[i] = new Array(hiddenWord.length+3).fill("");
}

const words = [];

for(var letter = 0; letter < hiddenWord.length; letter++){
	
	var k = Math.floor(Math.random() * values.length);
	for(let i = 0; i < values.length; i++){
		var check = values[k];
        k++;
        if(k >= values.length){
        	k = 0;
        }
        
        if(check.charAt(0) == hiddenWord.charAt(letter) && check.length <= (hiddenWord.length+3)){
  
        	if(!(words.includes(check))){
    			words.push(check);
              		break;
        	}       
    	}
    }
}

var nope = 0;
if(words.length != hiddenWord.length){
   	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}

else{

var wordBank = "<b> <p style=\"text-align:center;\">Word Bank</b> <br> ";

for(var val = 0; val < words.length; val++){
	wordBank += " " + words[val];

    	if((val%5 == 0) && (val !=0)){
    		wordBank += "<br>";
    	}
}

wordBank+= "</p><br>";

for(var val = 0; val < words.length; val++){
	var reverse = Math.floor(Math.random() * 2);
	var direction = Math.floor(Math.random() * 3);
	var word = words[val];
    	var fit = 0;
    	var dirCount = 0;
    	
	while(dirCount < 2 && fit == 0){
    		direction++;
    	
		if(direction >= 3){
    		direction = 0;
    	}
    
	if(reverse == 1){
    		var temp = "";
    	
		for(var letter = word.length-1; letter >= 0; letter--){
        		temp += word[letter];
        	}
        
		word = temp;
        	reverse = 0;
  	}
    	else{
    		reverse = 1;
    	}
  
   	if(direction == 2 && dirCount < 2 && fit == 0){
    		dirCount++;
    		var currentCol = Math.floor(Math.random() * grid.length);
        
		for(var col = 0; col < grid.length; col++){
        		currentCol++;
        	
			if(currentCol >= grid.length){
        			currentCol = 0;
        		}
                
			var currentRow = Math.floor(Math.random() * grid.length);
                
			for(var row = 0; row < grid[0].length; row++){
                		currentRow++;
            		
				if(currentRow >= grid[currentCol].length){
             				currentRow = 0;
            			}
                
                    		if((grid.length - currentCol) >= word.length && (grid[currentCol].length - currentRow >= word.length)){
                    	
					for(var letter = 0; letter < word.length; letter++){
                        			if(word.charAt(letter) == grid[currentCol+letter][currentRow+letter] || grid[currentCol+letter][currentRow+letter] == ""){
                            
                            				fit = 1;
                            			}
                            			else{
                            				fit = 0;
                                			break;
                            			}
                        
                        		}
                        	
					if(fit == 1){
                        			for(var letter = 0; letter < word.length; letter++){
                            				grid[currentCol+letter][currentRow+letter] = word.charAt(letter);
                            			}
                        		}    
                    
                    		}

                    		if(fit == 1){
            				break;
            	   		 }  
                }
                 if(fit == 1){
            		break;
            	}  
         
         }
    	
    
	}

    
    if(direction == 1  && dirCount < 2 && fit == 0){

    	dirCount++;
    	var currentRow = Math.floor(Math.random() * grid.length);

        for(var row = 0; row < grid[0].length; row++){
        	currentRow++;
            	if(currentRow >= grid[0].length){
             		currentRow = 0;
            	}
        	
		var currentCol = Math.floor(Math.random() * grid.length);

            	for(var col = 0; col < grid.length; col++){
            		currentCol++;
        		if(currentCol >= grid.length){
        			currentCol = 0;
			}
                if(grid.length - currentCol >= word.length){
                	for(var letter = 0; letter < word.length; letter++){

                    		if(word.charAt(letter) == grid[currentCol+letter][currentRow] || grid[currentCol+letter][currentRow] == ""){
                			fit = 1;
                		}
                		else{
                			fit = 0;
                    			break;
                		}
                    	}

                    	if(fit == 1){
                		for(var letter = 0; letter < word.length; letter++){
                    			grid[currentCol+letter][currentRow] = word.charAt(letter);
            			}
                	}
                
                }

                if(fit == 1){
            		break;
            	}   
            }
            if(fit == 1){
            	break;
            }
        }
    
    }
    
    if(direction == 0 && dirCount < 2 && fit == 0){
    	dirCount++;
    	var currentCol = Math.floor(Math.random() * grid.length);
	for(var col = 0; col < grid.length; col++){
    	currentCol++;

        if(currentCol >= grid.length){
        	currentCol = 0;
        }

    	var currentRow = Math.floor(Math.random() * grid[currentCol].length);

    	for(var row = 0; row < grid[currentCol].length; row++){
        	currentRow++;
            	if(currentRow >= grid[currentCol].length){
             		currentRow = 0;
            	}
        	
		if(grid[currentCol].length - currentRow >= word.length){
        		for(var letter = 0; letter < word.length; letter++){
            			if(word.charAt(letter) == grid[currentCol][currentRow+letter] || grid[currentCol][currentRow+letter] == ""){
                			fit = 1;
                		}
                		else{
                			fit = 0;
                    		break;
                		}
            		}
                
		if(fit == 1){
                	for(var letter = 0; letter < word.length; letter++){
	                    	grid[currentCol][currentRow+letter] = word.charAt(letter);
            		}
                }
            }

            if(fit == 1){
            	break;
            }
        }

        if(fit == 1){
        	break;
        }

	}
	}
    if(dirCount == 2 && fit ==0){
    	nope = 1;
    }
}
}
if(nope == 1){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}
else{
var out =  "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:13%\">";
var outPuz =  "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:13%\">";
for (var i = 0; i < grid.length; i++) {
out+="<tr>";
outPuz+="<tr>";
  for(var n = 0; n < (grid[i]).length; n++){
  		if(grid[i][n] == ""){
            		var tempLetter ="<td style=\"text-align:center\">" + String.fromCharCode(65 + Math.floor(Math.random() * 26)) + "</td>";
            		out+= tempLetter;
                	outPuz+= tempLetter;   
            	}
            	else{
            		out+= "<td style=\"text-align:center\"><b>";
        		out += grid[i][n];
            		outPuz += "<td style=\"text-align:center\">";
            		outPuz += grid[i][n];
            		outPuz+= "</td>";
            		out+= "</b></td>";
            	}
            	outPuz += "";
            	out+= ""; 
  }
  outPuz += "</tr>";
  out += "</tr>";
}

out+= "</table></font>";
outPuz+= "</table></font>";


endPuzzlesEND += "<br> <br><b> <p style=\"text-align:center;\">Word Search</p></b>"+outPuz + "<br>" + wordBank;
endSolutionEND += "<br> <br><b> <p style=\"text-align:center;\">Word Search Solution</p></b>" +out + "<br>" + wordBank + "<b> Hiden Word: </b>" + wordGiven;
}
}


}';

echo "
function double(wordGiven){


var word = wordGiven.toUpperCase();
var cookies = cookie.toUpperCase();
const values = cookies.split(\" \");";
echo 'const words = [];

for(let n = 0; n < word.length; n++){
	var k = Math.floor(Math.random() * values.length);
	for(let i = 0; i < values.length; i++){
		var check = values[k];
        k++;
        if(k >= values.length){
        	k = 0;
        }
    	if(check.charAt(0) == word.charAt(n)){
  
        	if(!(words.includes(check))){
    			words.push(check);
              		break;
        	}       
    	}
}
}
if(words.length != word.length){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}
else{
var list = "";
var solution = "";
for(let n = 0; n < words.length; n++){
	var text = words[n];
	var scramble = "";
	var temp = text;
	var temp2 = temp;
	var blanks = "";

	for(let i = 0; i < text.length; i++){
		temp = temp2;
		var number = Math.floor(Math.random() * temp.length);
		scramble += temp.charAt(number);
		temp2 = temp.substring(0, number) + temp.substring(number+1);
		blanks += "__ ";
	}

	if(scramble == text){
		n = n -1;
	}
	else{
		list += scramble + "<br> " + blanks + "<br>" + "<br>";
		solution += scramble + "<br>"  + text + "<br>" + "<br>";
	}


}
endPuzzlesEND += "<p style=\"text-align:center;\"><br> <br><b> Double Puzzle:</b> <br>The first letter of each word solution is a letter from the hidden word in the order that the letters appear. <br><br></p>"+ list +"<br>";
endSolutionEND += "<p style=\"text-align:center;\"><br> <br><b> Double Puzzle Solution:</b> <br> <br></p>" + solution+ "<br>" + "<b>Hidden Word: </b>" + word;
}

}';

echo "
 function dropQuote(wordGiven) {
var word = wordGiven.toUpperCase();
var cookies3 = cookie3.toUpperCase();
const values = cookies3.split(\",\");";
echo '
const words = [""];
var found = 0;
var loc = new Array(word.length);
var ranphrase = Math.floor(Math.random() * values.length);

for(var phrase = 0; phrase < values.length; phrase++){
	ranphrase++;
	if(ranphrase >= values.length){
		ranphrase = 0;
	}
    	
	var locLet = 0;
    	found = 0;
    
	for(var wordLet = 0; wordLet < word.length; wordLet++){
    		var ranlett = Math.floor(Math.random() * values[ranphrase].length);
	
			for(var letter = 0; letter < values[ranphrase].length; letter++){
    				ranlett++;
    				if(ranlett >= values[ranphrase].length){
        				ranlett = 0;
        			}
    			
				if(values[ranphrase].charAt(ranlett) == word.charAt(wordLet)){
        				loc[locLet] = ranlett;
            				locLet++;
          				found++;
           				break;
        			}
   			 }
    }
    if(found == word.length){
    		words[0] = values[ranphrase];
 		break;   
	}   
}
if(found != word.length){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}

else{
var grid;


for(var val = 0; val < words.length; val++){
	hints = "";
	var str = words[val];
    	var num = words[val].length;
    	var col = Math.ceil(num/10);
    	grid = new Array(col);

	for (var i = 0; i < grid.length; i++) {
  		grid[i] = new Array(10).fill("");
	}

    	const wordsList = str.split(" ");

 	for(var word = 0; word < wordsList.length; word++){
    		var temp = wordsList[word] + "%";
    		wordsList[word] = temp;
    		letter = 0;

    		for(var col = 0; col < grid.length; col++){

        		for(var row = 0; row < grid[0].length; row++){
            	
            			if(grid[col][row] == ""){
            				grid[col][row] = wordsList[word].charAt(letter);
               		 		letter++;

                			if(letter > wordsList[word].length){
                				if(col >= grid.length){
                    					col = 0;
                   				}
                   			if(row >= grid[0].length){
                    				row = 0;
                    			}
                   
                			break;
                	}		}
            	}
            	if(letter >= wordsList[word].length){
                	break;
                }
        }
        
    }
}
var solution = "";
for(var inArray = 0;  inArray < grid.length;  inArray++){
	for(var lett = 0; lett < grid[inArray].length; lett++){
		if(grid[inArray][lett] == ""){
			grid[inArray][lett] = "%";
		}
	}
}
var grid2 = new Array(10);
for (var inArray = 0; inArray < grid2.length; inArray++) {
  	grid2[inArray] = new Array(grid.length).fill("_");
}

for(var col = 0; col < grid.length; col++){
	for(var row = 0; row < grid[0].length; row++){
	if(grid[col][row] == " "){
		grid2[row][col] = "_";
	}
    	if(grid[col][row] != "%"){
        	grid2[row][col] = grid[col][row];
    	}
    }

}


for(var col = 0; col < grid.length; col++){
	for(var row = 0; row < grid[0].length; row++){
     	if(grid[col][row] == "%"){
         solution += "-";
        }
        else{
    	solution += grid[col][row];
        }
    
    }
    solution += "<br>";

}


var question = "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:15%\">";
for(var col = 0; col < grid.length; col++){
	question+= "<tr>";
	for(var row = 0; row < grid[0].length; row++){
      	if(grid[col][row] != "%"){
    	question += "<td style=\"text-align:center\"> __ </td>";
        }
        else{
        question += "<td style=\"text-align:center\">-</td>";
        }
    
    }
 	question+= "</tr>";

}
   question += "</table></font><br>";


for(var row = 0; row < grid2.length; row++){
	var count = 0;
	var k = Math.floor(Math.random() * grid2[0].length);
	for(var col = 0; col < grid2[0].length; col++){
    	k++;
        if(k >= grid2[0].length){
        	k = 0;
        }
    	grid[col][row] = " "+ grid2[row][k] +" ";
        if(grid[col][row] == " _ "){
        	var temp = grid[count][row];
            grid[col][row] = temp;
            grid[count][row] = " _ ";
            count++;
        }
    }

}

var hint = "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:26%\">";
for(var col = 0; col < grid.length; col++){
	hint+= "<tr>";
for(var row = 0; row < grid[0].length; row++){

	hint+= "<td style=\"text-align:center\">" + grid[col][row] + "</td>";

}
   hint+= "</tr>";
}
 hint += "</table></font>";





	
 endPuzzlesEND += "<p style=\"text-align:center;\"><br> <br><b> Drop Quote Puzzle</b><br> <br>" + "<br>" + hint + question + "<br>" + "<br> The letters of the hidden word in order (including spaces) are in the following positions:" + loc + "</p>";
 endSolutionEND += "<p style=\"text-align:center;\"><br> <br> Drop Quote Solution <br> <br>" +  solution +  "<br> <b>Hidden Word:</b>" + wordGiven+"</p>";

}


 
 }';


echo "
 function conjunctionJunction(wordGiven) {
var word = wordGiven.toUpperCase();
var cookies10 = cookie10.toUpperCase();
const values = cookies10.split(\",\"); 
//const values = [\"BOW AND ARROW\", \"BELIEVE IT OR NOT\", \"SILENT BUT DEADLY\", \"TIFFANY BUT CO\", \"SAFE AND SOUND\", \"EVIL ARE AND GOOD\", \"TALL OR SHORT\"];
const hintList = [];
const words = [];";
echo 'for(let n = 0; n < word.length; n++){
	var k = Math.floor(Math.random() * values.length);
	for(let i = 0; i < values.length; i++){
		var check = values[k];
        k++;
        if(k >= values.length){
        	k = 0;
        }
    	if(check.charAt(0) == word.charAt(n)){
        	if(!(words.includes(check))){
    		words.push(check);
            break;
        }       
    }
}
}
if(words.length != word.length){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}

else{

var hints = "";
var puzzle = "";
var hintEnd = Array();

for(var val = 0; val < words.length; val++){
	hints = "";
	var str = words[val];
    	var wordsList = str.split(" AND ");
    	var con = " AND ";
    
	if(wordsList.length < 2){
    		con = "OR";
       		wordsList = str.split(" OR ");
    	}
    
	if(wordsList.length < 2){
    		con = " BUT ";
       		wordsList = str.split(" BUT ");
    	}
    	
	var word = wordsList[0];
    	puzzle += word.replace(word.charAt(0), "__");
    	puzzle += "&emsp; &emsp;________ &emsp;&emsp;__ _____________";
    	word = wordsList[1];
    	hints += word.replace(word.charAt(0), "__");
    	hintEnd.push(hints);
    	puzzle += "<br>"; 
}

var solution = "";

for(var word = 0; word < words.length; word++){
	solution += words[word] + "<br>";
}

var secondBank = "<p style=\"text-align:center;\">"
var ran =  Math.floor(Math.random() * hintEnd.length);

for(var val = 0; val < hintEnd.length; val++){
	ran ++;
   	
	if(ran >= hintEnd.length){
    		ran = 0;
    	}

    	secondBank+= hintEnd[ran];
    	
	if(val%5 == 0 && val != 0){
    		secondBank+= "<br>";
    	}
}

secondBank+= "</p>";


endPuzzlesEND += "<br> <br><b> <p style=\"text-align:center;\">Conjunction Junction Puzzle </b> <br> <br>The conjunction between the two words/phrases can be AND, OR, or BUT. The first letter of each solved puzzle is a letter from the hidden word in the given order.<br>" + puzzle + "<br>" +"<br> <b> Second word or phrase bank: </b> </p> " + secondBank + "<br>";
endSolutionEND += "<br> <br><b> <p style=\"text-align:center;\">Conjunction Junction Solution </b><br> <br>" + solution + "</p><br><br><b>Hidden Word: </b>" + wordGiven.toUpperCase();

}
}
';

echo '
function acrostic(wordgiven){

var word = wordgiven.toUpperCase();
var cookies3 = cookie3.toUpperCase();
const values = cookies3.split(",");
const seekHints = cookie7.split("#");
var cookies = cookie.toUpperCase();
const seekWords = cookies.split(" ");
//const values = ["TE", "TO BE OR NOT TO BE THAT IS THE QUESTION", "TALK TO ME EVEN IF WE ARE NOT TOGETHER SAY",  "POTATO"];
//const seekHints = ["Leaf juice", "Burnt bread", "Something you listen with", "Something you sit on","The opposite of bottom", "A feline", "A bag"];
//const seekWords = ["TEA", "TOAST", "EAR", "SEAT", "TOP", "CAT", "TOAT"];
var endPhrase = "";
var found = 0;
var actualPhr = Math.floor(Math.random() * values.length);

for(var phrase = 0; phrase < values.length; phrase++){
 	actualPhr++;
    	if(actualPhr >= values.length){
    		actualPhr = 0;
	}

	var locLet = 0;
	found = 0;
	for(var wordLet = 0; wordLet < word.length; wordLet++){
    		var k = Math.floor(Math.random() * values[actualPhr].length);
	
		for(var letter = 0; letter < values[actualPhr].length; letter++){
    			k++;
    	
			if(k >= values[actualPhr].length){
        			k = 0;
        		}
    	
			if(values[actualPhr].charAt(k) == word.charAt(wordLet)){
            			locLet++;
           			found++;
         	  		break;
        		}
    		}
    	}

   	if(found == word.length){
   		endPhrase = values[actualPhr];
 		break;   
	}    
}
if(found != word.length){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}
else{
var endwords = new Array(word.length);
var lettCount = 0;
var loc = new Array(word.length);
var locHint = new Array(word.length);
for(var lett = 0; lett < word.length; lett++){
	var ranWord = Math.floor(Math.random() * seekWords.length);

	for(var wordLoop = 0; wordLoop < seekWords.length; wordLoop++){
    		ranWord ++;
        	
		if(ranWord >= seekWords.length){
        		ranWord  = 0;
        	}
    	
		if(seekWords[ranWord ].charAt(0) == word.charAt(lett) && !endwords.includes(seekWords[ranWord])){
        		var seekCount = 0;
            		loc[lett] = new Array(seekWords[ranWord ].length);
        		for(var slett = 0; slett < seekWords[ranWord].length; slett++){
            			var pletActual = Math.floor(Math.random() * endPhrase.length);
            			for(var plet = 0; plet < endPhrase.length; plet++){
                			pletActual++;
                    			
					if(pletActual >= endPhrase.length){
                     				pletActual = 0;
                    			}
                	
					if(seekWords[ranWord].charAt(slett) == endPhrase.charAt(pletActual)){
                 				loc[lett][seekCount] = pletActual ;
                    				seekCount++;
                    				break;
                    			}
                	}
            	}

            if(seekCount == seekWords[ranWord].length){
		locHint[lett] = seekHints[ranWord];         
        	endwords[lett] = seekWords[ranWord];
        	lettCount++;
        	break;
            }
      }
   
}
}
if(lettCount != word.length){
	error = 1;
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
}
else{
	var sol = "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:26%\">";
	var row = 0;
    	sol+= "<tr>";
	
	for(var lett = 0; lett < endPhrase.length; lett++){
    		if(endPhrase.charAt(lett) == " "){
        		sol += "<td style=\"text-align:center\">"+ "-" + "</td>";
        	}
        
		else{
        		sol+= "<td style=\"text-align:center\">"+ endPhrase.charAt(lett)+ "</td>";
        	}

        	row++;
        
		if(row > 10){
        		sol += "<tr>";
            		row = 0;
        	}
    	}
    	sol+= "</table></font> <br> <center>";
    
      	var puzzle = "<style> table, th, td { border: 1px solid black; margin-left:auto;margin-right:auto;border-collapse: collapse; } </style> <font size=\"4\"><table style=\"width:26%\">";
	var row = 0;
   	puzzle+= "<tr>";
	for(var lett = 0; lett < endPhrase.length; lett++){
    	
		if(endPhrase.charAt(lett) == " "){
        		puzzle += "<td style=\"text-align:center\">"+ "-" + "</td>";
        	}

	        else{
        		puzzle+= "<td style=\"text-align:center\"> __ <sub>"+ lett+ "</sub></td>";
        	}

       		row++;
        	if(row > 10){
        		puzzle += "<tr>";
            		row = 0;
        	}
    	}

    puzzle+= "</table></font> <br> <center>";
       
  	
     for(var end = 0; end < endwords.length; end++){
    	sol += endwords[end] + "&emsp;";
      
      	for(var lett = 0; lett < endwords[end].length; lett++){
        	puzzle+= " _ <sub>" + loc[end][lett] + "</sub>";
        }

        puzzle += "&emsp;";

        if((end + 1)% 2 == 0  && end != 0){
        	sol +=  "<br>";
            	puzzle += "<br>";
		sol += locHint[end-1];
		sol+= "&emsp;";
		puzzle += locHint[end-1];
		puzzle += "&emsp;";
		sol += locHint[end];
		sol += "<br>";
		puzzle += locHint[end];
		puzzle += "<br>";
        }
	else if(end == endwords.length -1){
		sol +=  "<br>";
            	puzzle += "<br>";
		sol += locHint[end];
		sol+= "&emsp;";
		puzzle += locHint[end];
		puzzle += "&emsp;";
	}  
    }
        puzzle+="</center>";
       	sol+= "</center>";
	endPuzzlesEND += "<br> <br><b> <p style=\"text-align:center;\">Acrostic Puzzle </b> <br> <br>The numbers correspond to matching letters between the grid quote and the words with hints. The hidden word is found by taking the first letter of each word with hints.<br>" + puzzle + "<br> </p> ";
	endSolutionEND += "<br> <br><b> <p style=\"text-align:center;\">Acrostic Solution </b><br> <br>" + sol + "</p><br><br><b>Hidden Word: </b>" + wordgiven.toUpperCase();
}
}
}
      
   function printPuzzle() {
		document.getElementById("puzzles").innerHTML = endPuzzlesEND+ "<br>";
      		var printThis = document.getElementById("puzzles").innerHTML;
      		document.getElementById("puzzles").innerHTML = "";
      		w=window.open();
      		w.document.write(printThis);
      		w.print();
        	w.close();
    }
    
    function printSolution() {
    		document.getElementById("solution").innerHTML = endSolutionEND + "<br>";
      		var printThis = document.getElementById("solution").innerHTML;
  		document.getElementById("solution").innerHTML = "";
        	w=window.open();
        	w.document.write(printThis);
        	w.print();
        	w.close();
    }
	

 

   
    const listSentence = sentence.split(" ");
    var curButton = Math.floor(Math.random() * 5);

    for(var wordSentence = 0; wordSentence < listSentence.length; wordSentence++){
        curButton++;
       
        if(curButton >= buttons.length){
        	curButton = 0;
        }

    	if(buttons[curButton] == 0){
   	        conjunctionJunction(listSentence[wordSentence]);

    	}

        else if(buttons[curButton] == 1){
         	dropQuote(listSentence[wordSentence]);
        }
        
        else if(buttons[curButton] == 2){
        	double(listSentence[wordSentence]);
        }
        
        else if(buttons[curButton] == 3){
         	wordSearch(listSentence[wordSentence]);
        }

	else if(buttons[curButton] == 4){
         	acrostic(listSentence[wordSentence]);
        }
	
	if(wordSentence < listSentence.length - 1){
		endSolutionEND += "<br><style> @media print { .pagebreak { page-break-before: always; } }</style> <div class=\"pagebreak\"> </div>";
		endPuzzlesEND +=" <br><style> @media print { .pagebreak { page-break-before: always; } }</style> <div class=\"pagebreak\"> </div>";
	}
   
    }

    if(error == 1){
    	alert("Error: Could not generate puzzle set. Please try again.");
	endSolutionEND = "ERROR";
	endPuzzlesEND = "ERROR";
    }     
    
</script>
	<head>
		<title>Puzzle Promenade - Download</title>
		<link rel="stylesheet" href="downloadstyle2.css"
		type="text/css">
	</head>


	<body>

		<div class="navbar">
  		<a href="index.html">Home</b>
  		<a href="about.html">About</a>
  		<a href="acrostic.html">Acrostic Puzzle</a>
  		<a href="double.html">Double Puzzle</a>
  		<a href="quote.html">Drop Quote Puzzle</a>
  		<a href="wordsearch.html">Word Search Puzzle</a>
  		<a href="conjunction.html">Conjunction Junction Puzzle</a>
		</div>

		<div class="heading">
			<span class="title">Puzzle Promenade</span>
			<span class="subtitle">Chain Puzzle Generating Website</span>		
			<br>
 		<form>

		<button class="downloadp" type="button" onclick="printPuzzle()">
			Download Puzzles	
		</button>


		<button class="downloads" type="button" onclick="printSolution()">
			Download Solution	
		</button>

		</div>
		
	</body>
</html> ';
	

 mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 mysqli_free_result($result3);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
}

 mysqli_free_result($result2);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
}
 

mysqli_close($link);
}
else{
echo "No Sentence inputted";
}

?>