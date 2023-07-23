import { Alert, AlertColor, Snackbar, Typography } from "@mui/material";

type NotificationProps = {
    open: boolean;
    message: string;
    title: string;
    severity: AlertColor | undefined;
    handleClose: () => void;
}

const Notification: React.FC<NotificationProps> = ({open,title,message,severity,handleClose}) => {
    return (
        <Snackbar 
            anchorOrigin={{vertical:'top', horizontal:'center'}}
            autoHideDuration={4000}
            open={open}
            onClose={handleClose}>
            <Alert title={title} severity={severity} onClose={handleClose}>
                <Typography>{message}</Typography>
            </Alert>
        </Snackbar>
    );
}

export default Notification;