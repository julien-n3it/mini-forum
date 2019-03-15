<?php
/* fonctions spécifiques */



/* fonctions dates */
function Isdateus ($date)
{
   $p_format["regional"] = "us";
   //   $expression="`^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$`";
   //   return preg_match($expression, $date);
   return Isdate($date, $p_format);
}
function Isdatefr ($date)
{
   //   $expression="`^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$`";
   //   return preg_match($expression, $date);
    
   $p_format["regional"] = "fr";
   return Isdate($date, $p_format);
}
function datefr($date)
{
   // Le format de la date paramétrée est en US puisque l'on cherche à la convertir en FR
   $p_format["regional"] = "us";
   return dateTo(substr($date,0,10), $p_format);
}
function dateus($date)
{
   // Le format de la date paramétrée est en FR puisque l'on cherche à la convertir en US
   $p_format["regional"] = "fr";
   return dateTo(substr($date,0,10), $p_format);
}

function Isdatetimeus ($date)
{
   $p_format["regional"] = "us";
   $p_format["time"] = true;
   $p_format["second"] = true;
   return Isdate($date, $p_format);
}
function Isdatetimefr ($date)
{
   //   $expression="`^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$`";
   //   return preg_match($expression, $date);
    
   $p_format["regional"] = "fr";
   $p_format["time"] = true;
   $p_format["second"] = true;
   return Isdate($date, $p_format);
}
function datetimefr($date)
{
   // Le format de la date paramétrée est en US puisque l'on cherche à la convertir en FR
   $p_format["regional"] = "us";
   $p_format["time"] = true;
   $p_format["second"] = true;
//   $p_format["second"] = true;
   return dateTo(substr($date,0,19), $p_format);
}

function datetimesanssecondesfr($date)
{
   // Le format de la date paramétrée est en US puisque l'on cherche à la convertir en FR
   $p_format["regional"] = "us";
   $p_format["time"] = true;
   $p_format["second"] = true;
   //$p_format["second"] = true;
   return dateTo(substr($date,0,19), $p_format);
}
function datetimeus($date)
{
   // Le format de la date paramétrée est en FR puisque l'on cherche à la convertir en US
   $p_format["regional"] = "fr";
   $p_format["time"] = true;
   $p_format["second"] = true;
   return dateTo(substr($date,0,19), $p_format);
}

/**
 * Retourne l'expression pour tester la date à mettre en paramètre du preg_match
 * @param array $p_format tableau indicé par le paramètre regional, time ou second
 * @return string $expression expression à tester correspondant au paramètre $p_format
 * @since 18/07/2013
 * @author fbekka
 */
function get_expr_date_for_preg_match ($p_format="")
{
   if(!isset($p_format["regional"]))
   $p_format["regional"] = "fr";
   if(!isset($p_format["time"]))
   $p_format["time"] = false;
   if(!isset($p_format["second"]))
   $p_format["second"] = false;

   $expression = "`^";
   if($p_format["regional"] == "us")
   $expression .= "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";
   else
   $expression .= "([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})";
   if($p_format["time"])
   $expression .=" ([0-9]{1,2}):([0-9]{1,2})";
   if($p_format["second"])
   $expression .=":([0-9]{1,2})";
   $expression .= "$`";

   return $expression;
}

/**
 * Teste si la chaine transmise est au format demandé en paramètre
 * @param string $date date au format DD/MM/AAAA ou YYYY-MM-DD
 * @param array $p_format tableau indicé par le paramètre regional, time ou second
 * @return boolean
 * @since 15/07/2013
 * @author fbekka
 */
function Isdate ($date, $p_format="")
{
   $expression = get_expr_date_for_preg_match ($p_format);
   if($date != null && $date != "")
   {
   	return preg_match($expression, $date);
   }else 
   return false;
}

/**
 * Retourne la date paramétrée dans le format inverse (si p_date=FR alors retourne US et inversement)
 * @param string $date date au format DD/MM/AAAA ou YYYY-MM-DD
 * @param array $p_format tableau indicé par le paramètre regional, time ou second
 * @return string date au format inverse de celui qui est paramétrée dans p_format
 * @since 22/07/2013
 * @author fbekka
 */
function dateTo($p_date, $p_format="")
{
   $expression = get_expr_date_for_preg_match ($p_format);
   preg_match($expression, $p_date, $regs);
   $date_a_retouner = "";

   if(trim($p_date)=="")
   {
      if($p_format["regional"] == "us")
      {
         $date_a_retouner = "0000-00-00";
         if($p_format["time"])
         $date_a_retouner .= " 00:00";
         if($p_format["second"])
         $date_a_retouner .= ":00";
      }
   }else
   {
      // Comme la date N'est PAS au format US donc on veut la convertir en US
      if ($p_format["regional"] != "us" && $regs[2]!='00' && $regs[1]!='00')
      {
         $date_a_retouner = $regs[3]."-".$regs[2]."-".$regs[1];
      }
      // Comme la date est au format US donc on veut la convertir en FR
      if ($p_format["regional"] == "us" && $regs[2]!='00' && $regs[3]!='00')
      {
         $date_a_retouner = $regs[3]."/".$regs[2]."/".$regs[1];
      }
      if ($date_a_retouner != "" && ($regs[4]!='' && $regs[5]!='' && $p_format["time"] || !$p_format["time"]))
      {
         if($p_format["time"])
         $date_a_retouner .= " ".$regs[4].":".$regs[5];

         if ($date_a_retouner != "" && ($regs[6]!='' && $p_format["second"] || !$p_format["second"]))
         {
            if($p_format["second"])
            $date_a_retouner .= ":".$regs[6];
         }
      }
   }
   if(substr($date_a_retouner,0,10) == "0000-00-00")
   $date_a_retouner = "";

   return $date_a_retouner;
}