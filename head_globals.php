<?php
$_SESSION['show_stock'] = false; // Stock Number... Shows For Everybody: (true or false)
$_SESSION['show_price'] = false; // For Guests, for login users it does not matter because it always shows the price.
$_SESSION['save_search'] = false; // Save users search input
$_SESSION['enable_regs'] = true; // Enable Distribuidor Sign Up.
$_SESSION['enable_carrito'] = false; // Enable cart / carrito compras

$_SESSION['banner_size'] = "auto";
$_SESSION['banner1'] = 'http://www2.cartimex.com/images/banners/ban1/banner1.jpg';
$_SESSION['banner2'] = 'http://www2.cartimex.com/images/banners/ban1/banner2.jpg';
$_SESSION['banner3'] = 'http://www2.cartimex.com/images/banners/ban1/banner3.jpg';
$_SESSION['banner4'] = 'http://www2.cartimex.com/images/banners/ban1/banner4.jpg';
$_SESSION['blink1'] = '#';
$_SESSION['blink2'] = '#';
$_SESSION['blink3'] = '#';
$_SESSION['blink4'] = '#';

$_SESSION['product1'] = '0000029692';
$_SESSION['product2'] = '0000030788';
$_SESSION['product3'] = '0000030265';
$_SESSION['product4'] = '0000028399';
$_SESSION['product5'] = '0000029089';
$_SESSION['product6'] = '0000028401';
$_SESSION['product7'] = '0000027129';
$_SESSION['product8'] = '0000029595';
$_SESSION['product9'] = '0000022820';

if (!isset($_SESSION['loggedin'])) {$_SESSION['loggedin'] = false;}



//----------------------------------
// Load Configuration from Database
//----------------------------------
require('dbcore.php');
$pdo_global = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);

// Show Stock
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='show_stock'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true") {$_SESSION['show_stock'] = true;}
		if ($row_global['VALUE'] == "false") {$_SESSION['show_stock'] = false;}
	}

// Show Price
$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='show_price'");
$statement_global->execute();
while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
	{
		if ($row_global['VALUE'] == "true"){$_SESSION['show_price'] = true;}
		if ($row_global['VALUE'] == "false"){$_SESSION['show_price'] = false;}
	}
	
	
// BANNERS (index.php)
function isHomePage()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ( in_array($path, ['/', '/index.php', '/demo/', '/demo/index.php']) )
		{
			return true;
		}
	else {return false;}
}
	
if (isHomePage() == true) 
	{
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner_size'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner_size'] = $row_global['VALUE']; $_SESSION['banner_size'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner1'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner1'] = $row_global['VALUE2']; $_SESSION['blink1'] = $row_global['VALUE3'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner2'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner2'] = $row_global['VALUE2']; $_SESSION['blink2'] = $row_global['VALUE3'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner3'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner3'] = $row_global['VALUE2']; $_SESSION['blink3'] = $row_global['VALUE3'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='banner4'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['banner4'] = $row_global['VALUE2']; $_SESSION['blink4'] = $row_global['VALUE3'];}
	}
	
// DESTACADOS (ofertas.php)
function isDestacados()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ( in_array($path, ['/ofertas.php', '/demo/ofertas.php', '/', '/index.php', '/demo/', '/demo/index.php']) )
		{
			return true;
		}
	else {return false;}
}
	
if (isDestacados() == true) 
	{
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product1'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product1'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product2'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product2'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product3'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product3'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product4'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product4'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product5'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product5'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product6'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product6'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product7'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product7'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product8'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product8'] = $row_global['VALUE'];}
		
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='product9'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC)){$_SESSION['product9'] = $row_global['VALUE'];}	
		
	}
	
// Save Search (buscar.php)
function isSearchPage()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ( in_array($path, ['/buscar.php', '/demo/buscar.php', '/producto.php', '/demo/producto.php', '/categoria.php', '/demo/categoria.php']) )
		{
			return true;
		}
	else {return false;}
}
if (isSearchPage() == true) 
	{
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='save_search'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
			{
				if ($row_global['VALUE'] == "true"){$_SESSION['save_search'] = true;}
				if ($row_global['VALUE'] == "false"){$_SESSION['save_search'] = false;}
			}
	}
	
// Enable Regs - Distribuidor Sign Up (registro.php) (registro2.php) 
function isRegPage()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ( in_array($path, ['/registro.php', '/demo/registro.php', '/registro2.php', '/demo/registro2.php']) )
		{
			return true;
		}
	else {return false;}
}
if (isRegPage() == true) 
	{
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='enable_regs'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
			{
				if ($row_global['VALUE'] == "true"){$_SESSION['enable_regs'] = true;}
				if ($row_global['VALUE'] == "false"){$_SESSION['enable_regs'] = false;}
			}
	}
	
// Enable Carrito - Cart / Carrito affects directly (cart_comprar.php) for "cart.php" is notification only
function isCartPage()
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ( in_array($path, ['/cart_comprar.php', '/demo/cart_comprar.php', '/cart.php', '/demo/cart.php']) )
		{
			return true;
		}
	else {return false;}
}
if (isCartPage() == true) 
	{
		$statement_global = $pdo_global->prepare("SELECT * FROM web_config WHERE CONFIG='enable_carrito'");
		$statement_global->execute();
		while($row_global = $statement_global->fetch(PDO::FETCH_ASSOC))
			{
				if ($row_global['VALUE'] == "true"){$_SESSION['enable_carrito'] = true;}
				if ($row_global['VALUE'] == "false"){$_SESSION['enable_carrito'] = false;}
			}
	}
?>