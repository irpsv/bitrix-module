<?php

namespace bitrix_module\iblock;

\CModule::includeModule('iblock');

class GetSectionAndElementByUrl
{
    protected $urlPart;
    protected $iblockCode;

    public static function runStatic(...$args)
    {
        $self = new self(...$args);
        return $self->run();
    }

    public function __construct(string $urlPart, string $iblockCode)
    {
        $this->urlPart = trim($urlPart, '/');
        $this->iblockCode = $iblockCode;
    }

    public function run()
    {
        $parts = explode('/', $this->urlPart);
        $len = count($parts);
        if ($len == 1) {
            return [
                $this->getSectionsByCode($parts[0])[0],
                null
            ];
        }
        else {
            $sections = $this->getSectionsByCode($parts[$len-1]);
            foreach ($sections as $section) {
                $sectionPath = \CIBlock::replaceDetailUrl($section['SECTION_PAGE_URL'], $section, false, 'S');
                if (trim($sectionPath, '/') === trim($this->urlPart, '/')) {
                    return [$section, null];
                }
            }

            $element = $this->getElementByCode($parts[$len-1]);
            if (!$element) {
                return [null, null];
            }

            $elementPath = \CIBlock::replaceDetailUrl($element['DETAIL_PAGE_URL'], $element, false, 'E');
            if (trim($elementPath, '/') !== trim($this->urlPart, '/')) {
                return [null, null];
            }

            $sections = $this->getSectionsByCode($parts[$len-2]);
            if (!$sections) {
                return [null, null];
            }

            $section = null;
            $urlPartSection = join('/', array_slice($parts, 0, -1));
            foreach ($sections as $section) {
                $sectionHasElement = \CIBlockSection::getList([], [
                    'ID' => $section['ID'],
                    'HAS_ELEMENT' => $element['ID'],
                ])->selectedRowsCount() > 0;
                if ($sectionHasElement) {
                    $sectionPath = \CIBlock::replaceSectionUrl($section['SECTION_PAGE_URL'], $section, false, 'S');
                    if (trim($sectionPath, '/') === trim($urlPartSection, '/')) {
                        return [$section, $element];
                    }
                }
            }
            return [null, null];
        }
    }

    public function getSectionsByCode(string $code)
    {
        $ret = [];
        $filter = [
            'CODE' => $code,
            'IBLOCK_CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ];
        $result = \CIBlockSection::getList([], $filter, false, ['ID', 'NAME', 'CODE', 'SECTION_PAGE_URL']);
        while ($row = $result->fetch()) {
            $ret[] = $row;
        }
        return $ret;
    }

    public function getElementByCode(string $code)
    {
        $filter = [
            'CODE' => $code,
            'IBLOCK_CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ];
        return \CIBlockElement::getList([], $filter)->fetch();
    }
}
