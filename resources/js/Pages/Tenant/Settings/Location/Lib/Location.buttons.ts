import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import { RouteName } from 'ziggy-js'
import Animal = App.Models.Animal

export function IndexActionButtons(
    resource: TranslationKey,
    createRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { can } = usePermission()

    return can('organisations.locations.create')
        ? [
              {
                  label: __('general.button.new', {
                      resource,
                  }),
                  variant: 'primary',
                  href: route(createRouteName),
              },
          ]
        : []
}

export function ShowActionButtons(
    animal: Animal,
    resource: TranslationKey,
    baseRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canUpdate, canDelete, canPublish } = usePermission()

    const PUBLISH_BUTTON: PageHeaderButton = {
        label: __('general.button.publish', {
            resource: '',
        }),
        variant: 'primary',
        method: 'post',
        href: route(baseRouteName + '.publish', animal.id),
    }

    const EDIT_BUTTON: PageHeaderButton = {
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: 'secondary',
        href: route(baseRouteName + '.edit', animal.id),
    }

    const DELETE_BUTTON: PageHeaderButton = {
        label: __('general.button.delete', {
            resource: '',
        }),
        variant: 'danger',
        method: 'delete',
        href: route(baseRouteName + '.destroy', animal.id),
    }

    const buttons = []

    if (canPublish(animal)) {
        buttons.push(PUBLISH_BUTTON)
    }
    if (canUpdate(animal)) {
        buttons.push(EDIT_BUTTON)
    }
    if (canDelete(animal)) {
        buttons.push(DELETE_BUTTON)
    }

    return buttons
}

export function FormActionButtons(
    cancelRoute: string,
    formId: string,
): PageHeaderButton[] {
    const __ = useTranslate()

    const SAVE_BUTTON: PageHeaderButton = {
        label: __('general.button.save', {
            resource: '',
        }),
        variant: 'primary',
        form: formId,
    }

    const CANCEL_BUTTON: PageHeaderButton = {
        label: __('general.button.cancel', {
            resource: '',
        }),
        variant: 'secondary',
        href: cancelRoute,
    }

    return [SAVE_BUTTON, CANCEL_BUTTON]
}
