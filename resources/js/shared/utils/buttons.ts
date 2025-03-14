import { RouteName } from 'ziggy-js'
import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import { usePage } from '@inertiajs/react'

export function CreateActionButton(
    resource: TranslationKey,
    createRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canCreate } = usePage().props

    return canCreate
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
