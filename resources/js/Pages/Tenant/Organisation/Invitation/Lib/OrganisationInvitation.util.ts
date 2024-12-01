import OrganisationInvitation = App.Models.OrganisationInvitation
import { BadgeColor } from '@/Components/_Base/Badge'
import { toTranslationKey } from '@/shared/hooks/useTranslate'

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
): TranslationKey => toTranslationKey('general.status.' + invitation.status)
