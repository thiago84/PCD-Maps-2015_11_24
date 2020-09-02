<?php

namespace App\Entity;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
abstract class Entity implements \JsonSerializable {

    /**
     * @Column(type="datetime", name="created_at", nullable=true)
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @Column(type="datetime", name="updated_at", nullable=true)
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * 
     * @return array
     */
	public function jsonSerialize() {
		$data = array();
        
        $reflectionClass = new \ReflectionClass(get_class($this));
        
        $data["type"] = $reflectionClass->getShortName();
        
		foreach(get_object_vars($this) as $field => $value) {
            if (is_a($value, "DateTime")) {
                $data[$field] = $value->format("d/m/Y H:i:s");
            } else {
                $data[$field] = $value;
            }
		}
        
        unset($data["__initializer__"]);
        unset($data["__cloner__"]);
        unset($data["__isInitialized__"]);
        
		return $data;
	}

    /**
     * @PrePersist
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function preUpdate() {
        $this->updatedAt = new \DateTime();
    }
}
