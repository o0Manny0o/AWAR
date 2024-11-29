import OrganisationInvitation = App.Models.OrganisationInvitation
import { BadgeColor } from '@/Components/_Base/Badge'

export const badgeColor = (
    invitation: Pick<OrganisationInvitation, 'status'>,
): BadgeColor => {
    switch (invitation.status) {
        case 'pending':
            return BadgeColor.WARN
        case 'sent':
            return BadgeColor.OTHER
        case 'accepted':
            return BadgeColor.SUCCESS
        default:
            return BadgeColor.SECONDARY
    }
}

export const badgeLabelKey = (
    invitation: Pick<OrganisationInvitation, 'status'>,
): TranslationKey => ('general.status.' + invitation.status) as TranslationKey

export const canEdit = (invitation: OrganisationInvitation) => {
    return false
}

export const canDelete = (invitation: OrganisationInvitation) => {
    return true
}

export const canRestore = (invitation: OrganisationInvitation) => {
    return false
}
