/*
   DHTML Tetris 1.0
   Copyright (c) 2002 Vitali Brusentsev
 */
var field;            // массив поля, хранит имена цветов.
var Rows=15, Cols=10; // размеры классического Tetris - "стакана"
var FigX=3, FigY=3;   // размеры фигурки
var fig;
var score=0;
var timeout=800;

var figureTemplates = new Array(
    "000111010|lightblue", 
    "011010010|dodgerblue", 
    "110010010|hotpink", 
    "011110000|tomato", 
    "110011000|seagreen", 
    "110110000|gold");
var kbLeft=37, kbRight=39, kbUp=38, kbDown=40, kbEsc=27, kbSpace=32; 
var rotationMatrix=new Array(2,5,8,1,4,7,0,3,6);
var backColor="#f2f2f2";

function Init()
{
    var col, row;
    field = new Array(Rows);
    for(row=0; row<Rows; row++)
    {
      field[row] = new Array(Cols);
      for(col=0; col<Cols; col++) field[row][col]=backColor;
    }
}

function RenderFirst()
{
    var inner = "";
    var col, row;
    for(row=0; row<Rows; row++)
    {
        inner += "<div>";
        for(col=0; col<Cols; col++) inner += "<span class='Cell' id='sp"+col+"x"+row+"'>&nbsp;</span>";
        inner += "</div>";
    }
    divField.innerHTML = inner;
}

function Render()
{
    var col, row;
    for(row=0; row<Rows; row++)
        for(col=0; col<Cols; col++) 
            document.all["sp"+col+"x"+row].style.backgroundColor=field[row][col];
    spanScore.innerText=score;
}

function Figure(text, x, y)
{
    this.x = x;
    this.y = y;
    this.color = text.split("|")[1];
    this.text  = text.split("|")[0];
    this.Draw = drawFigure;
    this.Print = printFigure;
    this.Rotate = rotateFigure;
    this.Move = moveFigure;
    this.Check = checkFigure;
    this.Cell = getCell;
}

function drawFigure()
{
    var col, row;
    for(row=0; row<FigY; row++)
        for(col=0; col<FigX; col++) 
            if(this.Cell(col,row)!=null)
                document.all["sp"+(col+this.x)+"x"+(row+this.y)].style.backgroundColor=this.Cell(col,row);
}

function printFigure()
{
    var col, row;
    for(row=0; row<FigY; row++)
        for(col=0; col<FigX; col++) 
            if(this.Cell(col,row)!=null) field[row+this.y][col+this.x] = this.Cell(col,row);
}

function rotateFigure()
{
    var newtext = ""; var oldtext=this.text;
    for(i=0;i<this.text.length;i++) newtext += this.text.charAt(rotationMatrix[i]);
    this.text=newtext;
    if(!this.Check()) this.text=oldtext;
}

function moveFigure(dx, dy)
{
    var oldX, oldY;
    oldX=this.x; oldY=this.y;
    this.x+=dx; this.y+=dy;
    if(!this.Check()){ this.x=oldX; this.y=oldY; return false; }
    return true;
}

function checkFigure()
{
    var col, row;
    for(row=0; row<FigY; row++)
        for(col=0; col<FigX; col++) 
        {
            if(this.Cell(col,row)!=null)
            { 
                if((row+this.y>=Rows) || (col+this.x>=Cols)) return false;
                if((row+this.y<0) || (col+this.x<0)) return false;
                if (field[row+this.y][col+this.x]!= backColor) return false;
            }
        }
    return true;
}

function getCell(x,y)
{
    return (this.text.charAt(x+FigX*y)=="0") ? null : this.color;
}

function RandomFigure()
{
    var template=Math.floor(Math.random()*figureTemplates.length);
    return new Figure(figureTemplates[template], 3, 0);
}

function Start()
{
    Init();
    RenderFirst();
    fig = RandomFigure();
    window.setTimeout("timerProc()", timeout);
    Render();
    fig.Draw();
}

function timerProc()
{
    if(!fig.Move(0,1)) 
    {
        fig.Print();
        fig=RandomFigure();
        if(!fig.Check()) { fig.Draw(); gameOver(); return; }
    }
    for(i=0;i<4;i++) SearchFullLine();
    Render();
    fig.Draw();
    window.setTimeout("timerProc()", timeout);
}

function keyProc()
{
    switch(event.keyCode)
    {
        case kbUp:   fig.Rotate();break;
        case kbLeft: fig.Move(-1,0);break;
        case kbRight:fig.Move(1,0);break;
        case kbDown:
        case kbSpace:
                     while(fig.Move(0,1)); break;
    }
    Render();
    fig.Draw();
}

function SearchFullLine()
{
    var col, row;
    for(row=Rows-1;row>=0;row--)
    {
        var full=true;
        for(col=0; col<Cols; col++)
            if(field[row][col]==backColor) full=false;
        if(full) { RemoveFullLine(row); score+=10; timeout-=30; if(timeout<0) timeout=50; break; }
    }
}

function RemoveFullLine(rowIndex)
{
    var col, row;
    for(row=rowIndex;row>0;row--)
        for(col=0; col<Cols; col++)
            field[row][col]=field[row-1][col];
    for(col=0; col<Cols; col++)
        field[0][col]=backColor;
}

function gameOver()
{
    alert("Game Over!\nYour score is "+score);
}
