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
        $this->urlPart = $urlPart;
        $this->iblockCode = $iblockCode;
    }

    public function run()
    {
        $parts = explode('/', $this->urlPart);
        $len = count($parts);
        if ($len == 1) {
            return [
                $this->getSectionByCode($parts[0]),
                null
            ];
        }
        else {
            $element = null;
            $section = $this->getSectionByCode($parts[$len-1]);
            if ($section) {
                $sectionPath = \CIBlock::replaceDetailUrl($section['SECTION_PAGE_URL'], $section, false, 'S');
                if (trim($sectionPath, '/') === trim($this->urlPart, '/')) {
                    return [$section, null];
                }
            }
            else {
                $element = $this->getElementByCode($parts[$len-1]);
            }

            if (!$element) {
                return [null, null];
            }

            $elementPath = \CIBlock::replaceDetailUrl($element['DETAIL_PAGE_URL'], $element, false, 'E');
            if (trim($elementPath, '/') !== trim($this->urlPart, '/')) {
                return [null, null];
            }

            $section = $this->getSectionByCode($parts[$len-2]);
            if (!$section) {
                return [null, null];
            }

            $sectionHasElement = \CIBlockSection::getList([], [
                'ID' => $section['ID'],
                'HAS_ELEMENT' => $element['ID'],
            ])->selectedRowsCount() > 0;
            if (!$sectionHasElement) {
                return [null, null];
            }

            $sectionPath = \CIBlock::replaceSectionUrl($section['SECTION_PAGE_URL'], $section, false, 'S');
            $urlPartSection = join('/', array_slice($parts, 0, -1));
            if (trim($sectionPath, '/') !== trim($urlPartSection, '/')) {
                return [null, null];
            }
            return [$section, $element];
        }
    }

    public function getSectionByCode(string $code)
    {
        $filter = [
            'CODE' => $code,
            'IBLOCK_CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ];
        return \CIBlockSection::getList([], $filter)->fetch();
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
