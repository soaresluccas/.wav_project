<?php
    session_start();
    include('../persistencia/config.php');

    if(isset($_SESSION['id'])){
        $artista = $_SESSION['id'];
        if(isset($_POST['nome']) || isset($_POST['tipo']) || isset($_POST['arquivo']) || isset($_POST['amostra']) || isset($_POST['capa']) || isset($_POST['categoria']) || isset($_POST['genero']) || isset($_POST['bpm']) || isset($_POST['nota']) || isset($_POST['escala']) || isset($_POST['preco'])){
            $nome = $_POST['nome'];
            $tipo = $_POST['tipo'];
            $arquivo = $_FILES['arquivo'];
            $amostra = $_FILES['amostra'];
            $capa = $_FILES['capa'];
            $categoria = $_POST['categoria'];
            $genero = $_POST['genero'];
            $bpm = $_POST['bpm'];
            $nota = $_POST['nota'];
            $escala = $_POST['escala'];
            $preco = $_POST['preco'];

            if($arquivo['error']){
                die("Falha ao enviar arquivo!");
            }
            if($amostra['error']){
                die("Falha ao enviar amostra!");
            }
            if($capa['error']){
                die("Falha ao enviar capa!");
            }

            $pastaArq = "audio/";
            $nomeArq = $arquivo['name'];
            $novoNomeArq =  uniqid();
            $extensaoArq = strtolower(pathinfo($nomeArq, PATHINFO_EXTENSION));

            if($extensaoArq != 'mp3' && $extensaoArq != 'mp4' && $extensaoArq != 'wav'){
                die("Tipo de arquivo não aceito!");
            }
            $pathArq = $pastaArq . $novoNomeArq . "." . $extensaoArq;

            $deuCertoArq = move_uploaded_file($arquivo['tmp_name'], "../$pathArq");

            $pastaAmo = "amostras/";
            $nomeAmo = $amostra['name'];
            $novoNomeAmo = uniqid();
            $extensaoAmo = strtolower(pathinfo($nomeAmo, PATHINFO_EXTENSION));

            if($extensaoAmo != 'mp3' && $extensaoAmo != 'mp4'){
                die("Tipo de amostra não aceita");
            }
            $pathAmo = $pastaAmo . $novoNomeAmo . "." . $extensaoAmo;

            $deuCertoAmo = move_uploaded_file($amostra['tmp_name'], "../$pathAmo");

            $pastaCapa = "img/";
            $nomeCapa = $capa['name'];
            $novoNomeCapa = uniqid();
            $extensaoCapa = strtolower(pathinfo($nomeCapa, PATHINFO_EXTENSION));

            if($extensaoCapa != 'png' && $extensaoCapa != 'jpg'){
                die("Tipo de Capa não aceito!");
            }
            $pathCapa = $pastaCapa . $novoNomeCapa . "." . $extensaoCapa;

            $deuCertoCapa = move_uploaded_file($capa['tmp_name'], "../$pathCapa");

            if($amostra == "null"){
                $amostra == 'default';
            }

            if($categoria == "null"){
                $categoria == 'default';
            }


            if($tipo == 'beat'){
                if($deuCertoArq || $deuCertoCapa){
                    $mysqli->query("INSERT INTO produtos VALUES (null, '$tipo', '$nome', '$pathCapa', '$pathArq', '$pathAmo', default, $artista, '$categoria', '$genero', $bpm, '$nota', '$escala', $preco, default, default, default)") or die($mysqli->error);
                    echo "<p>Upload realizado com sucesso!<p>";
                    header("location: perfil.html");
                }else{
                    echo "<p>Falha ao realizar upload!<p>";
                }
            }else{
                if($deuCertoAmo || $deuCertoArq || $deuCertoCapa){
                    $mysqli->query("INSERT INTO produtos VALUES (null, '$tipo', '$nome', '$pathCapa', '$pathArq', default, default, $artista, default, '$genero', default, default, default, $preco, default, default, default)") or die($mysqli->error);
                    echo "<p>Upload realizado com sucesso!!<p>";
                    header("location: perfil.php");
                }else{
                    echo "<p>Falha ao realizar upload!!<p>";
                }
            }
        }
    }else{
        echo("location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/upload.css">
    <title>.WAV STUDIOS | Upar um arquivo</title>
</head>
<body>
<section class="header">
        <div class="interface">
            <div class="off-screen-menu">
                <ul>
                    <li><a href="../plataform/plataform.php">Home</a></li>
                    <li><a href="../pages/explorar.php?tipo=beat">Beats</a></li>
                    <li><a href="../pages/explorar.php?tipo=drumkit">DrumKits</a></li>
                    <li><a href="../pages/explorar.php?tipo=loopkit">LoopKits</a></li>
                    <li><a href="#">Ebooks</a></li>
                </ul>
            </div>
          
            <nav>
                <div class="ham-menu">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
            </nav>
            <!-- /.ham_menu -->
            <div class="search">
                <form action="../pages/explorar.php" method="get">
                    <input type="text" name="query" id="busca" placeholder="Pesquise algo como Type beat ou DrumKits type...">
                    <button id="filter" type="submit">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <button type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
            </div>

            <!-- /.search -->
            <?php
                    if(!isset($_SESSION['id'])){
                ?>
                        <div class="nav_op">
                            <a href="../pages/login.php" id="entrar">Entrar</a>
                            <a href="" id="cad">Increver-se</a>
                        </div>
                <?php
                    }else{
                ?>
                        <div class="carrinho">
                            <div class="btn_car" id="car_button">
                                <i class="bi bi-cart3"></i>
                            </div>
                        </div>

                        <div class="card_car" id="card_car">
                <div class="header_car">
                    <h2>Carrinho</h2>

                    <div class="fechar_car" id="close_car">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </div>

                <div class="content_car">
                    <?php
                        $sqlCar = "SELECT carrinho.*, produtos.nome, produtos.preco FROM carrinho INNER JOIN produtos ON carrinho.idProduto = produtos.idProduto WHERE carrinho.idUsuario = 4";
                        $resultCar = $mysqli->query($sqlCar);
                        $total = 0;

                        if($resultCar->num_rows > 0){
                            while($row = $resultCar->fetch_assoc()){
                    ?>
                                <h4><?php echo $row['nome']?></h4>
                                <p><?php echo $row['quantidade']?></p>
                                <h4><?php echo $row['preco'] * $row['quantidade']?></h4>
                                <a href="../util/remover_do_carrinho.php?id=<?php echo $row['id']?>">Remover</a>
                            
                    <?php
                                $total += $row['preco'] * $row['quantidade'];
                            }
                        }else{
                            echo "<h4>Nenhum produto adicionado ao carrinho<h4>";
                        }
                    ?>
                
                    <div class="container_precos">
                        <h4>TOTAL:R$<?php echo $total?></h4>
                        <a href="../util/limpar_carrinho.php">
                            <button type="reset">LIMPAR CARRINHO</button> 
                        </a>
                    </div>

                   
                </div>

                <div class="footer_car">
                    <a href="" target="_blank">
                        <span>FINALIZAR COMPRA </span>
                        <i class="bi bi-check-lg"></i>
                    </a>
                </div>

                
            </div>

                        <div class="nav_myuser">
                            <div class="perfil_icon">
                                
                            </div>
                            <div class="user_screem_menu">
                                <div class="perfil_user">
                                    <a href="../pages/perfil.php">
                                        <div class="perfil_icon_off"></div>
                                        <div class="info_user">
                                            <h3><?php echo $_SESSION['nome']?></h3>
                                            <span><?php echo $_SESSION['email']?></span>
                                        </div>
                                    </a>
                                </div>

                                <ul>
                                    <li>
                                        <a href="../pages/favoritos.html">
                                            <i class="bi bi-bookmark-plus"></i>
                                            <span>Minha lista</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../pages/pedidos.html">
                                            <i class="bi bi-handbag"></i>
                                            <span>Pedidos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../pages/downloads.html" id="border_bottom">
                                            <i class="bi bi-download"></i>
                                            <span>Downloads</span>
                                        </a>
                                    </li>
                                </ul>

                                <a href="../util/logout.php" class="btn_logout">
                                    <span>Sair</span>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                ?>
            <!-- /.nav_op -->

        </div>
        <!-- /.interface -->
    </section>
    <!-- /.header -->


    <section class="filtro">
        
        <div class="interface">
            <div class="filtro_container" id="filtro_container">
                <form action="" method="get">
                    <label for="tipo">
                        <select name="tipo" id="tipo">
                            <option value="Beats">Beats</option>
                            <option value="Drum Kits">Drum Kits</option>
                            <option value="Loop Kits">Loop Kits</option>
                        </select>
                    </label>

                    <label for="fil-nome">
                        <input type="text" name="fil-nome" id="fil-nome" placeholder="Nome">
                    </label>

                    <label for="user">
                        <input type="text" name="user" id="user" placeholder="Usuário">
                    </label>

                    <label for="fil-genero">
                        <select name="fil-genero" id="fil-genero">
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                            <option value="Trap">Trap</option>
                           
                        </select>
                    </label>
                    <label for="fil-categoria">
                        <select name="fil-categoria" id="fil-categoria">
                            <option value="Guitarra">Guitarra</option>
                            <option value="Guitarra">Guitarra</option>
                            <option value="Guitarra">Guitarra</option>
                            <option value="Guitarra">Guitarra</option>
                            <option value="Guitarra">Guitarra</option>
                            <option value="Guitarra">Guitarra</option>
                           
                        </select>
                    </label>

                    <label for="fil-bpm">
                        <select name="fil-bpm" id="fil-bpm">
                            <option value="0-90">0-90</option>
                            <option value="90-120">90-120</option>
                            <option value="120-150">120-150</option>
                            <option value="150+">150+</option>
                        </select>
                    </label>

                    <label for="fil-tom">
                        <select name="fil-tom" id="fil-tom">
                            <option value="C">C</option>
                            <option value="C#">C#</option>
                            <option value="D">D</option>
                            <option value="D#">D#</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="F#">F#</option>
                            <option value="G">G</option>
                            <option value="G#">G#</option>
                            <option value="A">A</option>
                            <option value="A#">A#</option>
                            <option value="B">B</option>
                        </select>
                    </label>

                    <label for="fil-escala">
                        <select name="fil-escala" id="fil-escala">
                            <option value="Maior">Maior</option>
                            <option value="Menor">Menor</option>
                        </select>
                    </label>

                    <input type="submit" name="enviar" id="enviar" value="Filtrar">
                    <input type="reset" name="resetar" id="resetar" value="Limpar">
                </form>
            </div>
        </div>
        <!-- /.interface -->
    </section>
    <!-- /.topo_plat -->


    <section class="main">
        <div class="interface">
            <div class="container_form_up">

                <div class="tutorial">
                    <div class="card_1">
                        <h1>1 Dados Principal</h1>
                        <div class="divisor_card">
                            <div class="esfera"></div>
                            <div class="border_left"></div>
                            <div class="esfera"></div>
                        </div>
                    </div>
                    <div class="card_2">
                        <h1>2 Informe os detalhes do produto</h1>
                        <div class="divisor_card">
                            <div class="esfera"></div>
                            <div class="border_left"></div>
                            <div class="esfera"></div>
                        </div>
                    </div>
                    <div class="card_3">
                        <h1>3 Confira os dados, e selecione enviar</h1>
                        <div class="divisor_card">
                            <div class="esfera"></div>
                            <div class="border_left"></div>
                            <div class="esfera"></div>
                        </div>
                    </div>
                    
                </div>

                <div class="form">
                    <form method="post" enctype="multipart/form-data">
                        <label for="">Nome do Arquivo</label>
                        <input type="text" name="nome"required>
                        <label for="">Tipo do arquivo</label>
                        <select id="tipoArquivo" name="tipo">
                            <option value="">Selecione um produto</option>
                            <option value="beat">Beat</option>
                            <option value="drumkit">Drumkit</option>
                            <option value="loopkit">Loopkit</option>
                        </select>
                      <div class="hidden" id="extraFields">
                        <div class="flex_colum" >
                            <label class="margin_top" for="">Arquivo da musica (mp3, mp4, wav)</label>
                            <input id="select_arq" type="file" name="arquivo" required>
                            <label for="">Aquivo de amostra (mp3, mp4)</label>
                            <input id="select_arq" type="file" name="amostra">
                            <label for="">Arquivo da capa (png, jpg)</label>
                            <input id="select_arq" type="file" name="capa" required>
                            <label for="">Categoria</label>
                            <select name="categoria">
                                <option value="null" selected>Escolha uma categoria</option>
                                <option value="Arpeggio">Arpeggio</option>
                                <option value="Accordion">Accordion</option>
                                <option value="Bagpipe">Bagpipe</option>
                                <option value="Banjo">Banjo</option>
                                <option value="Bass">Bass</option>
                                <option value="Bass Guitar">Bass Guitar</option>
                                <option value="Bass Synth">Bass Synth</option>
                                <option value="Bass Wobble">Bass Wobble</option>
                                <option value="Beatbox">Beatbox</option>
                                <option value="Bells">Bells</option>
                                <option value="Brass">Brass</option>
                                <option value="Choir">Choir</option>
                                <option value="Clarinet">Clarinet</option>
                                <option value="Didgeridoo">Didgeridoo</option>
                                <option value="Drum">Drum</option>
                                <option value="Flute">Flute</option>
                                <option value="Fx">Fx</option>
                                <option value="Groove">Groove</option>
                                <option value="Guitar Acoustic">Guitar Acoustic</option>
                                <option value="Guitar Electric">Guitar Electric</option>
                                <option value="Harmonica">Harmonica</option>
                                <option value="Harp">Harp</option>
                                <option value="Harpsichord">Harpsichord</option>
                                <option value="Mandolin">Mandolin</option>
                                <option value="Orchestral">Orchestral</option>
                                <option value="Organ">Organ</option>
                                <option value="Pad">Pad</option>
                                <option value="Percussion">Percussion</option>
                                <option value="Piano">Piano</option>
                                <option value="Rhodes Piano">Rhodes Piano</option>
                                <option value="Scratch">Scratch</option>
                                <option value="Sitar">Sitar</option>
                                <option value="Soundscapes">Soundscapes</option>
                                <option value="Strings">Strings</option>
                                <option value="Synth">Synth</option>
                                <option value="Table">Table</option>
                                <option value="Ukulele">Ukulele</option>
                                <option value="Violin">Violin</option>
                                <option value="Vocal">Vocal</option>
                                <option value="Woodwind">Woodwind</option>
                            </select>
                            <label for="">Genero</label>
                            <select name="genero" required>
                                <option value="null" selected>Escolha um genero</option>
                                <option value="8bit Chiptune">8bit Chiptune</option>
                                <option value="Acid">Acid</option>
                                <option value="Acoustic">Acoustic</option>
                                <option value="Afrobeat">Afrobeat</option>
                                <option value="Ambient">Ambient</option>
                                <option value="Big Room">Big Room</option>
                                <option value="Blues">Blues</option>
                                <option value="Boom Bap">Boom Bap</option>
                                <option value="Breakbeat">Breakbeat</option>
                                <option value="Chill Out">Chill Out</option>
                                <option value="Cinematic">Cinematic</option>
                                <option value="Classical">Classical</option>
                                <option value="Comedy">Comedy</option>
                                <option value="Country">Country</option>
                                <option value="Crunk">Crunk</option>
                                <option value="Dance">Dance</option>
                                <option value="Dancehall">Dancehall</option>
                                <option value="Deep House">Deep House</option>
                                <option value="Dirty">Dirty</option>
                                <option value="Disco">Disco</option>
                                <option value="Drum And Bass">Drum And Bass</option>
                                <option value="Dub">Dub</option>
                                <option value="Dubstep">Dubstep</option>
                                <option value="EDM">EDM</option>
                                <option value="Eletronic">Eletronic</option>
                                <option value="Ethnic">Ethnic</option>
                                <option value="Folk">Folk</option>
                                <option value="Funk">Funk</option>
                                <option value="Fusion">Fusion</option>
                                <option value="Garage">Garage</option>
                                <option value="Glitch">Glitch</option>
                                <option value="Grime">Grime</option>
                                <option value="Grunge">Grunge</option>
                                <option value="Hardcore">Hardcore</option>
                                <option value="Hardstyle">Hardstyle</option>
                                <option value="Heavy Metal">Heavy Metal</option>
                                <option value="Hip Hop">Hip Hop</option>
                                <option value="House">House</option>
                                <option value="Indie">Indie</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Jazz">Jazz</option>
                                <option value="Jungle">Jungle</option>
                                <option value="Latin">Latin</option>
                                <option value="Lo-Fi">Lo-Fi</option>
                                <option value="Moombahton">Moombahton</option>
                                <option value="Orchestral">Orchestral</option>
                                <option value="Phonk">Phonk</option>
                                <option value="Pop">Pop</option>
                                <option value="Psychedelic">Psychedelic</option>
                                <option value="Punk">Punk</option>
                                <option value="Rap">Rap</option>
                                <option value="Rave">Rave</option>
                                <option value="Reggae">Reggae</option>
                                <option value="Reggaeton">Reggaeton</option>
                                <option value="Religious">Religious</option>
                                <option value="RnB">RnB</option>
                                <option value="Rock">Rock</option>
                                <option value="Samba">Samba</option>
                                <option value="Ska">Ska</option>
                                <option value="Soul">Soul</option>
                                <option value="Spoken Word">Spoken Word</option>
                                <option value="Techno">Techno</option>
                                <option value="Trance">Trance</option>
                                <option value="Trap">Trap</option>
                                <option value="Trip Hop">Trip Hop</option>
                                <option value="UK Drill">UK Drill</option>
                                <option value="Weird">Weird(?)</option>
                            </select>
                            <label for="">BPM</label>
                            <input type="number" name="bpm">
                            <label for="">Nota</label>
                            <select name="nota" >
                                <option value="null" selected>Escolha uma nota</option>
                                <option value="C">C</option>
                                <option value="C#">C#</option>
                                <option value="D">D</option>
                                <option value="D#">D#</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="F#">F#</option>
                                <option value="G">G</option>
                                <option value="G#">G#</option>
                                <option value="A">A</option>
                                <option value="A#">A#</option>
                                <option value="B">B</option>
                            </select>
                            <label for="">Escala</label>
                            <select name="escala">
                                <option value="null" selected>Escolha uma escala</option>
                                <option value="maior">Maior</option>
                                <option value="menor">Menor</option>
                            </select>
                            <select name="formPay" id="">
                                <option value="gratuito">Gratuito</option>
                                <option value="pago">Pago</option>
                            </select>
                            <label for="">Preço</label>
                            <input type="number" name="preco" required>
                            <button type="submit">Enviar</button>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="interface">
            <div class="footer_logo">
                <p>.wav studios</p>
                <span><i class="bi bi-c-circle"></i></span>
            </div>
            <div class="footer_container">
                <div class="nav_footer" >
                    <h2>.wavstudios</h2>
                    <div id="ajuste">
                        <div id="ajuste2">
                            <a href="#">Sobre nós</a>
                            <a href="#">Política de Privacidade</a>
                        </div>

                        <div id="ajuste2">
                            <a href="#">Termos e Condições</a>
                            <a href="#">Política de Reembolso</a>
                        </div>
                    </div>
                    
                </div>
            
                <div class="nav_footer">
                    <h2>links úteis</h2>
                    <a href="#">Perguntas Frequentes</a>
                    <a href="#">Catálogos</a>
                </div>
                <div class="nav_footer">
                    <h2>Nosso Servidor do Discord</h2>
                    <div class="nav_footer_social">
                        <a href="#" class="social_btn">
                            <i class="bi bi-discord"></i>
                        </a>
                    </div>
                </div>
                <div class="nav_footer">
                    <h2>siga-nos</h2>
                  <div class="nav_footer_social">
                    <a class="social_btn" href="#"><i class="bi bi-instagram"></i></a>
                    <a class="social_btn" href="#"><i class="bi bi-envelope"></i></a>
                  </div>
                </div>

                
            </div>
        </div>
        <div class="footer_cpbar">
            <span>
                <i class="bi bi-c-circle"></i> 2024
                Todos os direitos reservados.

            </span>
            <span>
                xx.xxx.xxx/xxxxx-xx | RS - Porto Alegre 
            </span>
            
        </div>
    </footer>
</body>
<script>
    document.getElementById('tipoArquivo').addEventListener('change', function() {
        var extraFields = document.getElementById('extraFields');
        if (this.value) {
            extraFields.classList.add('show'); 
            var flexColum = extraFields.querySelector('.flex_colum');
            flexColum.classList.add('show'); 
        } else {
            extraFields.classList.remove('show'); 
            var flexColum = extraFields.querySelector('.flex_colum');
            flexColum.classList.remove('show'); 
        }
    });
</script>
<script src="../script/myuser.js"></script>
<script src="../script/filtro.js"></script>
<script src="../script/app.js"></script>
<script src="../script/car.js"></script>
</html>
