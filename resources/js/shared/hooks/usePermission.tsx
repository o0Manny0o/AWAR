import { usePage } from '@inertiajs/react'
import { get } from 'lodash-es'

export default function usePermission(base?: ResourcePermissions) {
    const { permissions } = usePage().props

    const can = (ability: ResourcePermissions) =>
        get(permissions, [...(base ? [base] : []), ability].join('.'), false)

    return {
        can,
    }
}
