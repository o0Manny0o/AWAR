export default function usePermission() {
    const canDelete = (e: any): boolean => e.can_be_deleted ?? false
    const canRestore = (e: any): boolean => e.can_be_restored ?? false
    const canUpdate = (e: any): boolean => e.can_be_updated ?? false
    const canView = (e: any): boolean => e.can_be_viewed ?? false
    const canSubmit = (e: any): boolean => e.can_be_submitted ?? false
    const canResend = (e: any): boolean => e.can_be_resend ?? false
    const canPublish = (e: any): boolean => e.can_be_published ?? false
    const canAssign = (e: any): boolean => e.can_assign ?? false

    return {
        canDelete,
        canRestore,
        canUpdate,
        canView,
        canSubmit,
        canResend,
        canPublish,
        canAssign,
    }
}
