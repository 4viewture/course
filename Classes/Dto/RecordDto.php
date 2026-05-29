<?php

namespace FourViewture\Course\Dto;

class RecordDto implements \JsonSerializable
{
    protected ?int $uid = null;
    protected int $pid = 0;
    protected string $number = '';
    protected int $deleted = 0;
    protected int $hidden = 0;
    protected string $import_source = '';
    protected string $import_id = '';
    protected string $course_type = '';
    protected string $course_description = '';
    protected string $course_index = '';
    protected ?int $course_start_date = null;
    protected ?int $course_end_date = null;
    protected string $costs = '';
    protected string $costs_text = '';
    protected string $additional_text = '';
    protected int $available_places = 0;
    protected string $link_for_registration = '';
    protected string $link_for_agb = '';
    protected int $address = 0;
    protected string $categories = '';

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->fromArray($data);
        }
    }

    public function fromArray(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if ($key === 'uid' || $key === 'pid' || $key === 'deleted' || $key === 'hidden' || $key === 'course_start_date' || $key === 'course_end_date' || $key === 'available_places' || $key === 'address') {
                    $this->{$key} = $value === null ? null : (int)$value;
                } else {
                    $this->{$key} = (string)$value;
                }
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'pid' => $this->pid,
            'number' => $this->number,
            'deleted' => $this->deleted,
            'hidden' => $this->hidden,
            'import_source' => $this->import_source,
            'import_id' => $this->import_id,
            'course_type' => $this->course_type,
            'course_description' => $this->course_description,
            'course_index' => $this->course_index,
            'course_start_date' => $this->course_start_date,
            'course_end_date' => $this->course_end_date,
            'costs' => $this->costs,
            'costs_text' => $this->costs_text,
            'additional_text' => $this->additional_text,
            'available_places' => $this->available_places,
            'link_for_registration' => $this->link_for_registration,
            'link_for_agb' => $this->link_for_agb,
            'address' => $this->address,
            'categories' => $this->categories,
        ];

        if ($this->uid !== null) {
            $data['uid'] = $this->uid;
        }

        return $data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getUid(): ?int { return $this->uid; }
    public function setUid(?int $uid): self { $this->uid = $uid; return $this; }

    public function getPid(): int { return $this->pid; }
    public function setPid(int $pid): self { $this->pid = $pid; return $this; }

    public function getNumber(): string { return $this->number; }
    public function setNumber(string $number): self { $this->number = $number; return $this; }

    public function getDeleted(): int { return $this->deleted; }
    public function setDeleted(int $deleted): self { $this->deleted = $deleted; return $this; }

    public function getHidden(): int { return $this->hidden; }
    public function setHidden(int $hidden): self { $this->hidden = $hidden; return $this; }

    public function getImportSource(): string { return $this->import_source; }
    public function setImportSource(string $import_source): self { $this->import_source = $import_source; return $this; }

    public function getImportId(): string { return $this->import_id; }
    public function setImportId(string $import_id): self { $this->import_id = $import_id; return $this; }

    public function getCourseType(): string { return $this->course_type; }
    public function setCourseType(string $course_type): self { $this->course_type = $course_type; return $this; }

    public function getCourseDescription(): string { return $this->course_description; }
    public function setCourseDescription(string $course_description): self { $this->course_description = $course_description; return $this; }

    public function getCourseIndex(): string { return $this->course_index; }
    public function setCourseIndex(string $course_index): self { $this->course_index = $course_index; return $this; }

    public function getCourseStartDate(): ?int { return $this->course_start_date; }
    public function setCourseStartDate(?int $course_start_date): self { $this->course_start_date = $course_start_date; return $this; }

    public function getCourseEndDate(): ?int { return $this->course_end_date; }
    public function setCourseEndDate(?int $course_end_date): self { $this->course_end_date = $course_end_date; return $this; }

    public function getCosts(): string { return $this->costs; }
    public function setCosts(string $costs): self { $this->costs = $costs; return $this; }

    public function getCostsText(): string { return $this->costs_text; }
    public function setCostsText(string $costs_text): self { $this->costs_text = $costs_text; return $this; }

    public function getAdditionalText(): string { return $this->additional_text; }
    public function setAdditionalText(string $additional_text): self { $this->additional_text = $additional_text; return $this; }

    public function getAvailablePlaces(): int { return $this->available_places; }
    public function setAvailablePlaces(int $available_places): self { $this->available_places = $available_places; return $this; }

    public function getLinkForRegistration(): string { return $this->link_for_registration; }
    public function setLinkForRegistration(string $link_for_registration): self { $this->link_for_registration = $link_for_registration; return $this; }

    public function getLinkForAgb(): string { return $this->link_for_agb; }
    public function setLinkForAgb(string $link_for_agb): self { $this->link_for_agb = $link_for_agb; return $this; }

    public function getAddress(): int { return $this->address; }
    public function setAddress(int $address): self { $this->address = $address; return $this; }

    public function getCategories(): string { return $this->categories; }
    public function setCategories(string $categories): self { $this->categories = $categories; return $this; }
}
