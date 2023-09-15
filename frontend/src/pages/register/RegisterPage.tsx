import RegisterIcon from '@mui/icons-material/AppRegistrationOutlined';
import Avatar from '@mui/material/Avatar';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Container from '@mui/material/Container';
import CssBaseline from '@mui/material/CssBaseline';
import Grid from '@mui/material/Grid';
import Link from '@mui/material/Link';
import TextField from '@mui/material/TextField';
import Typography from '@mui/material/Typography';
import axios from 'axios';
import { NavLink, useNavigate } from 'react-router-dom';

const endpoint = 'http://localhost:8001/api/client/web/register';

const RegisterPage = () => {
    const navigate = useNavigate();
    const handleSubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData(event.currentTarget);
        const name = formData.get('name');
        const password = formData.get('password');
        const rePassword = formData.get('repassword');
        const email = formData.get('email');

        if (password !== rePassword) {
            alert('Password dont match - Confirm password');
            return;
        }

        try {
            const { data } = await axios.post(
                endpoint,
                {
                    name,
                    email,
                    password,
                }
            );
            if (data.id) {
                navigate('/login');
                return;
            }

            alert('Registration Failed!');
        } catch (error: any) {
            const errors = await error.response.data.errors;
            alert(errors.join('\n\n'));
        }
    };

    return (
        <Container component='main' maxWidth='xs'>
            <CssBaseline />
            <Box
                sx={{
                    marginTop: 8,
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                }}
            >
                <Avatar sx={{ m: 1, bgcolor: 'primary.main' }}>
                    <RegisterIcon />
                </Avatar>
                <Typography component='h1' variant='h5'>
                    Register
                </Typography>
                <Box
                    component='form'
                    onSubmit={handleSubmit}
                    noValidate
                    sx={{ mt: 1 }}
                >
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        id='name'
                        label='Name'
                        name='name'
                        autoComplete='name'
                        autoFocus
                    />
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        id='email'
                        label='Email Address'
                        name='email'
                        autoComplete='email'
                        autoFocus
                    />
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        name='password'
                        label='Password'
                        type='password'
                        id='password'
                        autoComplete='password'
                    />
                    <TextField
                        margin='normal'
                        required
                        fullWidth
                        name='repassword'
                        label='Confirm Password'
                        type='password'
                        id='repassword'
                        autoComplete='repassword'
                    />
                    <Button
                        type='submit'
                        fullWidth
                        variant='contained'
                        sx={{ mt: 3, mb: 2 }}
                    >
                        Sign In
                    </Button>
                    <Grid container>
                        <Grid item>
                            <Link
                                component={NavLink}
                                to='/login'
                                variant='body1'
                            >
                                {'You have an account? Sign In'}
                            </Link>
                        </Grid>
                    </Grid>
                </Box>
            </Box>
        </Container>
    );
};

export default RegisterPage;
