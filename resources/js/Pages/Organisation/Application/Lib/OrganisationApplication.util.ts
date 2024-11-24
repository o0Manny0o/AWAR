import Application = App.Models.OrganisationApplication
import { BadgeColor } from '@/Components/_Base/Badge'

export const badgeColor = (application: Application): BadgeColor => {
    if (application.deleted_at) {
        return BadgeColor.DANGER
    }
    switch (application.status) {
        case 'draft':
            return BadgeColor.WARN
        case 'submitted':
            return BadgeColor.SECONDARY
        case 'pending':
            return BadgeColor.OTHER
        case 'rejected':
            return BadgeColor.DANGER
        case 'approved':
            return BadgeColor.SUCCESS
        case 'created':
            return BadgeColor.SUCCESS
        default:
            return BadgeColor.SECONDARY
    }
}

export const badgeLabelKey = (application: Application): TranslationKey => {
    return application.deleted_at
        ? 'general.deleted'
        : (('general.status.' + application.status) as TranslationKey)
}

export const canEdit = (application: Application) => {
    return !application.is_locked
}

export const canDelete = (application: Application) => {
    return !application.deleted_at && !application.is_locked
}

export const canRestore = (application: Application) => {
    return application.deleted_at && !application.is_locked
}
