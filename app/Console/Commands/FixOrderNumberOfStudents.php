<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\CommandEvent;
use App\Models\Schools ;

class FixOrderNumberOfStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixOrderNumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schools = Schools::all();
        foreach ($schools as $school){
            $students = $school->students()->orderBy('ordernumber','ASC')->get() ;
            $lastStudent=0;
            foreach ($students as $student)
            {
                if($student->ordernumber != 1 && (($student->ordernumber-1) == $lastStudent) ){
                    $lastStudent = $student->ordernumber ;
                }else{
                    $student->ordernumber = $lastStudent + 1 ;
                    $student->save();
                    $lastStudent = $student->ordernumber ;
                }
            }
        }   

        event(new CommandEvent('Test@troylab.com','Hi we finished'));
    }
}
