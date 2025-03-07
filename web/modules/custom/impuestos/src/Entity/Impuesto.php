<?php

namespace Drupal\impuesto\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the Impuesto entity.
 *
 * @ContentEntityType(
 *   id = "impuesto",
 *   label = @Translation("Impuesto"),
 *   base_table = "impuesto",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "nombre"
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\impuesto\ImpuestoListBuilder",
 *     "form" = {
 *       "default" = "Drupal\impuesto\Form\ImpuestoForm",
 *       "add" = "Drupal\impuesto\Form\ImpuestoForm",
 *       "edit" = "Drupal\impuesto\Form\ImpuestoForm",
 *       "delete" = "Drupal\impuesto\Form\ImpuestoDeleteForm"
 *     },
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler"
 *   },
 *   links = {
 *     "canonical" = "/impuesto/{impuesto}",
 *     "add-form" = "/impuesto/add",
 *     "edit-form" = "/impuesto/{impuesto}/edit",
 *     "delete-form" = "/impuesto/{impuesto}/delete",
 *     "collection" = "/admin/structure/impuesto"
 *   },
 *   field_ui_base_route = "impuesto.settings"
 * )
 */
class Impuesto extends ContentEntityBase implements ImpuestoInterface {

  use EntityChangedTrait;
  
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Empieza con los campos básicos de las entidades de contenido.
    $fields = parent::baseFieldDefinitions($entity_type);
  
    // Campo ID.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('El ID de la entidad Impuesto.'))
      ->setReadOnly(TRUE);
  
    // Campo UUID.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('El UUID de la entidad Impuesto.'))
      ->setReadOnly(TRUE);
  
    // Campo "nombre".
    $fields['nombre'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nombre'))
      ->setDescription(t('El nombre del impuesto.'))
      ->setSettings([
        'max_length' => 255,
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
    // Campo "valor" (para almacenar el porcentaje del IVA).
    $fields['valor'] = BaseFieldDefinition::create('integer') 
      ->setLabel(t('Valor'))
      ->setDescription(t('El porcentaje del IVA.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_integer', 
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',  
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
    // Campo para guardar la fecha de la última modificación.
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Última modificación'))
      ->setDescription(t('La fecha de la última modificación del impuesto.'));
  
    return $fields;
  }
}