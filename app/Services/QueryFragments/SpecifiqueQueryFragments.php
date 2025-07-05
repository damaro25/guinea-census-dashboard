<?php

namespace App\Services\QueryFragments;

use Uneca\Chimera\Services\AreaTree;

class SpecifiqueQueryFragments
{
    private $codeToSql = [
        'REGION' => "SUBSTRING(i6, 1, 1)",
        'PRÉFECTURE' => "LPAD(SUBSTRING(i6, 1, 2), 2, '0')",
        'SOUS-PRÉFECTURE/COMMUNE' => "SUBSTRING(i6, 1, 4)",
        'ZS' => "i4a",
        'ZC' => "i5",
        'ZD' => "i6",
    ];

    public function getSqlFragments(string $filterPath) : array
    {
        $filter = AreaTree::pathAsFilter($filterPath);
        $fromTables = [];


        if( ! blank($filter['ZC'] ?? null)){
            $selectColumns = ["{$this->codeToSql['ZD']}  AS area_code"];
            $whereConditions = ["{$this->codeToSql['ZC']} = '{$filter['ZC']}'",
                "{$this->codeToSql['ZS']} = '{$filter['ZS']}'",
                "{$this->codeToSql['SOUS-PRÉFECTURE/COMMUNE']} = '{$filter['SOUS-PRÉFECTURE/COMMUNE']}'",
                "{$this->codeToSql['PRÉFECTURE']} = '{$filter['PRÉFECTURE']}'",
                "{$this->codeToSql['REGION']} = '{$filter['REGION']}'"];
        }
        elseif( ! blank($filter['ZS'] ?? null)){
            $selectColumns = ["{$this->codeToSql['ZC']}  AS area_code"];
            $whereConditions = [
                "{$this->codeToSql['ZS']} = '{$filter['ZS']}'",
                "{$this->codeToSql['SOUS-PRÉFECTURE/COMMUNE']} = '{$filter['SOUS-PRÉFECTURE/COMMUNE']}'",
                "{$this->codeToSql['PRÉFECTURE']} = '{$filter['PRÉFECTURE']}'",
                "{$this->codeToSql['REGION']} = '{$filter['REGION']}'"];
        }
        elseif (!blank($filter['SOUS-PRÉFECTURE/COMMUNE'] ?? null)) {
            $selectColumns = ["{$this->codeToSql['ZS']}  AS area_code"];
            $whereConditions = ["{$this->codeToSql['SOUS-PRÉFECTURE/COMMUNE']} = '{$filter['SOUS-PRÉFECTURE/COMMUNE']}'",
                "{$this->codeToSql['PRÉFECTURE']} = '{$filter['PRÉFECTURE']}'",
                "{$this->codeToSql['REGION']} = '{$filter['REGION']}'"];

        }
        elseif (!blank($filter['PRÉFECTURE'] ?? null)){
            $selectColumns = ["{$this->codeToSql['SOUS-PRÉFECTURE/COMMUNE']}  AS area_code"];
            $whereConditions = ["{$this->codeToSql['PRÉFECTURE']} = '{$filter['PRÉFECTURE']}'",
                "{$this->codeToSql['REGION']} = '{$filter['REGION']}'"];
        }
        elseif (! blank($filter['REGION'] ?? null)) {
            $selectColumns = ["{$this->codeToSql['PRÉFECTURE']}  AS area_code"];
            $whereConditions = ["{$this->codeToSql['REGION']} = '{$filter['REGION']}'"];
        }else {
            $selectColumns = ["{$this->codeToSql['REGION']}  AS area_code"];
            $whereConditions = [];
        }
        return [$selectColumns, $whereConditions, $fromTables];
    }
}
