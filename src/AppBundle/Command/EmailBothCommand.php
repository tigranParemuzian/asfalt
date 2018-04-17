<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class EmailBothCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:email_both_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $t = str_replace('.com', '.com, ',
            str_replace('.fr', '.fr, ',
                str_replace('.ru', '.ru, ',
                    str_replace('.ge', '.ge ,',
                    str_replace('.it', '.it ,',
                        file_get_contents(__DIR__.'/emails.txt')
                    )
                    )
                )
            )
        );

        $fs = new Filesystem();

        $filePath = __DIR__.'/../../../web/uploads/files/';



        $results = [];
        $t = explode(', ', $t);
        $i = 0;
        $emails = '';
        foreach ($t as $key=>$value){

            $value = str_replace(',', '',$value);
            if(!in_array($value, $results) && strlen((string)$value)>5){
                $i ++;
                $results[]=$value;
                $emails.=$value."\n";
                if($i%500 === 0){
                    $file = $filePath.'emais_'.$i.'.txt';
                    $fs->touch($file);
                    $fs->dumpFile($file, $emails);
                    $emails = '';
                }

                $output->write('emails cnt '.$i);
            }
        }

        $output->write('finished');
    }
}
