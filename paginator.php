<?php
/**
 * Create the pagination from two dimensional (2D) arrays with column sorting
 *
 * PHP version 7
 *
 * @param  $pageNumber Set number of selected page
 * @param  $sortColumn Set sort column number
 * @param  $sortOrder  Set sort order mode (i.e. ascessing = 0, descessing = 1)
 *
 * @method	public  fetch2DArrayPaginationData($pageNumber, $sortColumn, $sortOrder): array
 * @method  public  getPagesCount(): int Get pages count from data
 * @method  public  getColumnsCount(): int Get columns count from data
 * @method  public  getSortingModes(): array Get predefined sortings modes
 * @method public getTotalRows(): int Get total items of data
 *
 * @return	string	Pagination pages count
 * @return	string	Columns count
 * @return	string	Sorting modes
 *
 * @author Einars Maslinovskis <stuzeneger@rambler.ru>
 */
 
class Paginator
{

    private $data = [];
    private $rowsInPage;
	private $totalRows;

    public function __construct(array $data, int $rowsInPage)
    {
        $this->data = $data;
        $this->totalRows=count($data);
		$this->rowsInPage = $rowsInPage > 0 ? $rowsInPage : $this->totalRows; //check if $rowsInPage not null
    }

    public function fetch2DArrayPaginationData($pageNumber, $sortColumn, $sortOrder): array
    {
        $data = $this->data;
        $startOf = $pageNumber * $this->rowsInPage;

        switch ($sortOrder)
        {
            case 0:
            default:
                $sortingOrder = constant('SORT_ASC');
            break;

            case 1:
                $sortingOrder = constant('SORT_DESC');
            break;
        }

        $sortColum = array_column($this->data, $sortColumn);
		
        @array_multisort($sortColum, $sortingOrder, SORT_NATURAL, $this->data);

        $data = array_slice($this->data, $startOf, $this->rowsInPage);

        return $data;
    }
	
    public function getPagesCount(): int
    {
        $pagesCount = ceil($this->totalRows / $this->rowsInPage);
        return $pagesCount;
    }

    function getColumnsCount(): int
    {
        $columnsCount = max( array_map('count', $this->data));
        return $columnsCount;
    }
	
    public function getSortingModes(): array
    {
        $sortingModes = [['caption' => 'Ascessing', 'mode' => 0], ['caption' => 'Descessing', 'mode' => 1]];
        return $sortingModes;
    }
	
    public function getTotalRows(): int
    {
    return $this->totalRows;
    }

}