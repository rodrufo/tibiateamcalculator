<?php

namespace brisacode;

use Rain\Tpl;


class page{

    private $header;
    private $footer;
    private $tpl;

    public function __construct($opts = [], $header = true, $footer = true, $loop = [])
    {

        $this->header = $header;
        $this->footer = $footer;

        $config = array(
            "tpl_dir"       => "app/views/",
            "cache_dir"     => "app/views/cache/",
            "debug"         =>true
        );

        Tpl::configure($config);
        $this->tpl = new Tpl;

        if (count($opts) > 0) {

            $this->setOpt($opts);
        }

        if (count($loop) > 0) {

            $this->setOpt($loop);
        }

        if ($this->header) {

            $this->tpl->draw('header');
        }
    }


    public function gerarPagina($pagina,  $opts = [], $loop = [], $returnHTML = false)
    {

        if (count($opts) > 0) {

            $this->setOpt($opts);
        }

        if (count($loop) > 0) {

            $this->setOpt($loop);
        }

        $this->tpl->draw($pagina, $returnHTML);
    }


    public function __destruct()
    {

        if ($this->footer) {

            $this->tpl->draw('footer');
        }
    }




    private function setOpt($opts)
    {

        foreach ($opts as $key => $value) {

            $this->tpl->assign($key, $value);
        }
    }
}



