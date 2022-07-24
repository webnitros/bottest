<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.07.2022
 * Time: 17:45
 */

namespace App\Helpers;

class Funcompare
{
    private $_oldLabel = 'old';
    private $_newLabel = 'new';

    public function label($oldLabel, $newLabel)
    {
        !empty($oldLabel) && $this->_oldLabel = $oldLabel;
        !empty($newLabel) && $this->_newLabel = $newLabel;
        return $this;
    }

    public function compareText($oldString, $newString)
    {
        $oldArr = preg_split('/\s+/', $oldString);
        $newArr = preg_split('/\s+/', $newString);
        $resArr = array();

        $oldCount = count($oldArr) - 1;
        $tmpOldIndex = 0;
        $tmpNewIndex = 0;
        $end = false;

        while (!$end) {
            if ($tmpOldIndex <= $oldCount) {
                if (isset($oldArr[$tmpOldIndex]) && isset($newArr[$tmpNewIndex]) && $oldArr[$tmpOldIndex] === $newArr[$tmpNewIndex]) {
                    array_push($resArr, $oldArr[$tmpOldIndex]);
                    $tmpOldIndex++;
                    $tmpNewIndex++;
                } else {
                    $foundKey = array_search($oldArr[$tmpOldIndex], $newArr, true);
                    if ($foundKey != '' && $foundKey > $tmpNewIndex) {


                        $lastNew = $resArr;

                        $last = array_pop($lastNew);
                        // Если равно
                        if ($last === '<old:{%}>') {
                            array_pop($resArr);
                        }
                        for ($p = $tmpNewIndex; $p < $foundKey; $p++) {
                            array_push($resArr, $newArr[$p]);
                            #array_push($resArr, sprintf('<%s:%s>', $this->_newLabel, $newArr[$p]));
                        }
                        array_push($resArr, $oldArr[$tmpOldIndex]);
                        $tmpOldIndex++;
                        $tmpNewIndex = $foundKey + 1;
                    } else {
                        array_push($resArr, sprintf('<%s:%s>', $this->_oldLabel, $oldArr[$tmpOldIndex]));
                        $tmpOldIndex++;
                    }
                }
            } else {
                $end = true;
            }
        }

        $textFinal = '';
        foreach ($resArr as $val) {
            $textFinal .= $val . ' ';
        }
        return $textFinal;
    }

    public function compareArray($oldArr, $newArr)
    {
        $result = array();

        $keys = array_unique(array_merge(array_keys((array)$oldArr), array_keys($newArr)));
        foreach ($keys as $k) {
            if (isset($oldArr[$k]) && isset($newArr[$k])) {
                if (is_array($oldArr[$k]) && is_array($newArr[$k])) {
                    $tmp = $this->compareArray($oldArr[$k], $newArr[$k]);
                    if ($tmp) {
                        $result[$k] = $tmp;
                    }
                } elseif (is_array($oldArr[$k]) || is_array($newArr[$k]) || $oldArr[$k] != $newArr[$k]) {
                    $result[$k][$this->_oldLabel] = $oldArr[$k];
                    $result[$k][$this->_newLabel] = $newArr[$k];
                }
            } elseif (isset($oldArr[$k]) && !isset($newArr[$k])) {
                $result[$k][$this->_oldLabel] = $oldArr[$k];
                $result[$k][$this->_newLabel] = null;
            } elseif (!isset($oldArr[$k]) && isset($newArr[$k])) {
                $result[$k][$this->_oldLabel] = null;
                $result[$k][$this->_newLabel] = $newArr[$k];
            }
        }

        return $result;
    }

    public function compareJson($oldJson, $newJson)
    {
        $oldArr = json_decode($oldJson, true);
        $newArr = json_decode($newJson, true);
        $res = $this->compareArray($oldArr, $newArr);
        return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}
