<?php
require_once 'DAO.php';
require_once 'classes/application_config.php';
require_once 'classes/dto/UsuarioDTO.php';
require_once 'classes/util/Log4Php.php';
require_once 'classes/dao/LoteDAO.php';
require_once 'classes/dao/BenfeitoriaDAO.php';

class UsuarioDAO extends DAO {
    
    public static $instancia = null;
    
    public static function getInstancia() {
        
        if (self::$instancia == NULL) {
            self::$instancia = new UsuarioDAO();
        }
        return self::$instancia;
    }
    
    private function __construct() {}
    
    
    public function login($email, $senha){
        
            
        $pdo = self::obterConexaoBaseDados();
        
        $sql = "SELECT * FROM usuario WHERE email = '{$email}'";
        
        $stm = $pdo->query($sql);
        
        if ($stm->rowCount() > 0) {
            
            if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                
                $senhaInformada = hash("md5", $senha);
                $senhaBd = $linha['senha'];
                
                if(strcmp($senhaInformada, $senhaBd) == 0){
                    
                    $usuario = new UsuarioDTO();
                    $usuario->setCelular($linha['celular']);
                    $usuario->setEmail($email);
                    $usuario->setId($linha['id']);
                    $usuario->setNome($linha['nome']);
                    $usuario->setNumeroLote($linha['nr_lote']);
                    $usuario->setPerfil($linha['id_perfil']);
                    
                    if($usuario->getNumeroLote() > 0){
                        $usuario->setContribui(
                            LoteDAO::getInstancia()->verificarSeLoteContribui($usuario->getNumeroLote()));
                    } else {
                        $usuario->setContribui(false);
                    }
                                            
                    return $usuario;
                    
                } else {
                    //-- Senha invalida
                    throw new Exception("Senha invalida.", "401");
                }
                
            }
        } else {
            //-- Usuario nao encontrado
            throw new Exception("Usuario nao encontrado.", "404");
        }
        
    }
    
    
    public function inserirUsuario($email, $senha, $nome, $lote = null, $celular){
        
        try {
            
            if(!isset($lote) || empty($lote)){
                $lote = 0;
            }
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "INSERT INTO usuario (email, id_perfil, senha, nome, nr_lote, celular) VALUES ('{$email}',0,'{$senha}','{$nome}',{$lote},'{$celular}')";
            
            $pdo->exec($sql);

            return $pdo->lastInsertId();
            
        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao incluir usuario: ". $erro->getMessage());
            
            if(strpos($erro->getMessage(), 'Integrity constraint violation') !== false){
                throw new Exception("Usuário ja existe com o email informado: ". $erro->getMessage(), 409);
            } else {
                throw new Exception("Erro ao incluir usuario: ". $erro->getMessage());
            }
        }
        
    }

    public function atualizarUsuario($id, $email, $nome, $lote, $celular){

        try {
            
            if(!isset($lote) || empty($lote)){
                $lote = 0;
            }
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE usuario SET email = '{$email}', nome = '{$nome}', nr_lote = {$lote}, celular = '{$celular}' WHERE id = {$id} ";
            
            $pdo->exec($sql);

        } catch (Exception $erro){

            Log4Php::logarFatal("Erro ao atualizar usuario: ". $erro->getMessage());
            
            if(strpos($erro->getMessage(), 'Integrity constraint violation') !== false){
                throw new Exception("Usuário ja existe com o email informado: ". $erro->getMessage(), 409);
            } else {
                throw new Exception("Erro ao incluir usuario: ". $erro->getMessage());
            }
        }

    }

    
    public function atualizarSenha($id, $novaSenha){

        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "UPDATE usuario SET senha = '{$novaSenha}' WHERE id = {$id} ";
            
            $pdo->exec($sql);

        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao atualizar senha do usuario: ". $erro->getMessage());
            throw new Exception("Erro ao atualizar senha do usuario: ". $erro->getMessage());
        }

    }

    public function excluir($id){
        try {
            
            $pdo = self::obterConexaoBaseDados();
            
            $sql = "DELETE FROM usuario WHERE id = {$id} ";
            
            $pdo->exec($sql);

        } catch (Exception $erro){
            Log4Php::logarFatal("Erro ao excluir usuario: ". $erro->getMessage());
        }
    }
    
    public function obterUsuario($id){
        
        $pdo = self::obterConexaoBaseDados();
        
        $sql = "SELECT * FROM usuario WHERE id = {$id}";
        
        $stm = $pdo->query($sql);
        
        if ($stm->rowCount() > 0) {
            
            if ($linha = $stm->fetch(PDO::FETCH_ASSOC)) {
                
                $usuario = new UsuarioDTO();
                $usuario->setCelular($linha['celular']);
                $usuario->setEmail($linha['email']);
                $usuario->setId($linha['id']);
                $usuario->setNome($linha['nome']);
                $usuario->setNumeroLote($linha['nr_lote']);
                $usuario->setPerfil($linha['id_perfil']);
                
                if($usuario->getNumeroLote() > 0){
                    $usuario->setContribui(
                        LoteDAO::getInstancia()->verificarSeLoteContribui($usuario->getNumeroLote()));
                    
                    $usuario->setContribuicoesBenfeitorias(
                        BenfeitoriaDAO::getInstancia()->obterContribuicoesBenfeitoriasPorLote($usuario->getNumeroLote()));
                } else {
                    $usuario->setContribui(false);
                }

                return $usuario;
           }
           
        } else {
            throw new Exception("Usuario nao encontrado.", "404");
        }        
    }
}