pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/shopmarket.git'
                echo 'Pulled from GitHub successfully'
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
