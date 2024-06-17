pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/shopmarket.git'
                echo 'Pulled from GitHub successfully'
            }
        }

        stage('Instalar extensión dom para PHP') {
            steps {
                script {
                    sudo('apt-get update')
                    sudo('apt-get install -y php8.1-xml')
                }
            }
        }

        stage('Instalar Composer') {
            steps {
                script {
                    def EXPECTED_SIGNATURE = sh(script: "wget -q -O - https://composer.github.io/installer.sig", returnStdout: true).trim()
                    sh "php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\""
                    def ACTUAL_SIGNATURE = sh(script: "php -r \"echo hash_file('SHA384', 'composer-setup.php');\"", returnStdout: true).trim()
                    if (EXPECTED_SIGNATURE != ACTUAL_SIGNATURE) {
                        error 'ERROR: Invalid installer signature'
                    }
                    sh 'php composer-setup.php --quiet'
                    sh 'RESULT=$?'
                    sh 'rm composer-setup.php'
                    sh 'mv composer.phar composer'
                    sh 'exit $RESULT'
                }
            }
        }

        stage('Instalar dependencias') {
            steps {
                sh 'php composer install'
            }
        }

        stage('Verifica version php') {
            steps {
                sh 'php --version'
            }
        }

        stage('Ejecutar php') {
            steps {
                sh 'php index.php'
            }
        }
    }
}
