<?php
$data = $_SESSION['view_data'] ?? [];
$logins = $data['logins'] ?? [];
?>

<h1 class="pb-3 border-bottom">Dashboard</h1>

<!-- Přidáme React a Babel CDN -->
<script src="https://unpkg.com/react@18/umd/react.development.js"></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>


<section class="mt-5">
    <h2>Poslední přihlášení</h2>
    
    <!-- Root element pro React aplikaci -->
    <div id="login-logs"></div>

    <!-- React komponenta -->
    <script type="text/babel">
        function LoginLogs({ initialLogs }) {
            const [logs, setLogs] = React.useState(initialLogs);
            const [limit, setLimit] = React.useState(10);

            const handleDeleteLog = (loginTime) => {
                setLogs(logs.filter(log => log.login_time !== loginTime));
            };

            return (
                <div>
                    <div className="mb-3">
                        <label htmlFor="limit" className="form-label">Počet zobrazených záznamů:</label>
                        <input
                            type="number"
                            className="form-control w-auto"
                            id="limit"
                            value={limit}
                            onChange={(e) => setLimit(Math.max(1, parseInt(e.target.value) || 0))}
                            min="1"
                        />
                    </div>
                    
                    <div className="table-responsive">
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>Jméno</th>
                                    <th>Příjmení</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Čas přihlášení</th>
                                    <th>Akce</th>
                                </tr>
                            </thead>
                            <tbody>
                                {logs.slice(0, limit).map((login, index) => (
                                    <tr key={index}>
                                        <td>{login.firstname}</td>
                                        <td>{login.lastname}</td>
                                        <td>{login.email}</td>
                                        <td>{login.role}</td>
                                        <td>{new Date(login.login_time).toLocaleString('cs')}</td>
                                        <td>
                                            <button 
                                                className="btn btn-sm btn-danger"
                                                onClick={() => handleDeleteLog(login.login_time)}
                                            >
                                                Smazat
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            );
        }

        // Vykreslení komponenty
        const container = document.getElementById('login-logs');
        const root = ReactDOM.createRoot(container);
        root.render(<LoginLogs initialLogs={<?php echo json_encode($logins); ?>} />);
    </script>
</section>