<?php

namespace App\Services\QueryFragments;

use Uneca\Chimera\Services\AreaTree;

class ListingExtQueryFragments
{
    private $codeToSql = [
        'REGION' => "SUBSTRING(cons_zd_id, 1, 1)",
        'PRÉFECTURE' => "LPAD(SUBSTRING(cons_zd_id, 1, 2), 2, '0')",
        'SOUS-PRÉFECTURE/COMMUNE' => "SUBSTRING(cons_zd_id, 1, 4)",
        'ZS' => "cons_zs_id",
        'ZC' => "cons_zc_id",
        'ZD' => "cons_zd_id",
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
        $whereConditions = ['(cons_is_deleted <> 4 or cons_is_deleted is null)',...$whereConditions];        
        return [$selectColumns, $whereConditions, $fromTables];
    }
}
